Extbase Editor Refactor Plan
============================

Goal
----

This plan defines a clean migration path for the BusinessView editor to a real
Extbase form flow. The target architecture is:

* dedicated Extbase actions for editor and save
* one mapped form data structure (DTO-like array)
* Fluid form rendering only inside Extbase request context
* JavaScript focused on editor interaction only

Current pain points
-------------------

The current editor template set mixes several concerns:

* backend module rendering and frontend plugin rendering
* partials with ``f:form.*`` fields outside one clear form model
* nested/manual hidden field conventions for different records
* JavaScript and server mapping tightly coupled through ad-hoc names

This leads to brittle updates and recurring Fluid context errors.

Target action structure
-----------------------

Create or align one dedicated editor controller (existing controller can be used
first, extraction to a new controller can be done later):

* ``editAction(int $businessViewUid = 0)``
  * loads BusinessView, Panoramas, Address
  * maps domain objects to one ``editorForm`` array
  * assigns ``editorForm`` and JSON bootstrap payload for JS
* ``updateAction(array $editorForm)``
  * validates minimal required fields
  * maps ``editorForm`` back into domain objects
  * persists changes in one application service
* optional ``newAction()`` / ``createAction(array $editorForm)``
  * for first-time setup

DTO/form structure
------------------

Use one normalized request payload, for example:

.. code-block:: php

   [
     'businessView' => [
       'uid' => 12,
       'pid' => 34,
       'title' => 'Store Berlin',
       'settings' => [
         'color' => '#ffffff',
         'backgroundColor' => '#000000',
         'textColor' => '#222222',
         'align' => 'left',
         'panoJumpTimer' => 5000,
         'panoRotationTimer' => 30,
         'panoRotationFactor' => 1.0,
         'panoJumpsRandom' => true,
       ],
     ],
     'panoramas' => [
       [
         'uid' => 100,
         'title' => 'Entrance',
         'panoId' => 'abc123',
         'heading' => 180,
         'pitch' => 0,
         'zoom' => 1,
         'position' => 10,
       ],
     ],
     'address' => [
       'uid' => 90,
       'name' => 'Store Berlin Mitte',
       'cid' => 'google-place-id',
       'latitude' => 52.520008,
       'longitude' => 13.404954,
     ],
   ]

Template strategy
-----------------

1. Keep one canonical editor template rendered from Extbase action only.
2. Wrap all editable fields inside one ``f:form`` bound to ``editorForm``.
3. Move field rendering into partials that receive sub-arrays only
   (``businessView``, ``panoramas``, ``address``).
4. Keep ``f:form.validationResults`` in a single shared error partial.

JavaScript split
----------------

* Extbase provides initial payload (server source of truth)
* JS manipulates UI and mirrors values into the form model
* submit goes to ``updateAction`` only
* server-side service handles final mapping and persistence

Recommended implementation steps
--------------------------------

1. Add ``EditorFormMapper`` service with:
   * ``fromDomain(Tp3BusinessView $businessView): array``
   * ``toDomain(array $editorForm, Tp3BusinessView $businessView): Tp3BusinessView``
2. Add ``editAction`` and ``updateAction`` to dedicated controller.
3. Introduce one editor template + partials bound to ``editorForm``.
4. Move current hidden/manual field names to normalized keys in mapper.
5. Adapt JS selectors to the normalized form field names.
6. Add smoke functional test for edit->update roundtrip.

Validation checklist
--------------------

* no Fluid error: ``f:form can be used only in extbase context``
* submit includes valid trusted properties token
* existing panoramas can be updated and reordered
* new panorama can be created
* address geo fields persist correctly
* no regression in frontend BusinessView rendering

Compatibility / migration notes
-------------------------------

* Keep old action routes temporarily as compatibility aliases.
* Add deprecation notes in changelog for old field names.
* Remove legacy mixed templates after one release cycle.
