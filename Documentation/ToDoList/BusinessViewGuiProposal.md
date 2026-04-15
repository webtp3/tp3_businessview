# Vorschlag: bessere GUI für den BusinessView-Designer

## Zielbild
Die aktuelle Basis ist stark: `JsonResponseHandler` + `ModuleController` liefern schon die nötigen Daten/Endpoints.
Im Frontend sollte die Oberfläche vom "Daten-Viewer" zu einem echten "Editor" weiterentwickelt werden – mit klarer Bearbeitungslogik, Live-Steuerung des Panoramas und sicherem Speichern.

## Kernprobleme heute
1. **Gemischte Oberfläche**: Liste, Viewer und Edit-Felder sind parallel sichtbar; es gibt keinen klaren Bearbeitungsmodus.
2. **Unklare Save-Logik für Updates**: Für `update` wird eine Panorama-UID benötigt, im Formular ist das Feld aber nur versteckt vorhanden und im Flow nicht immer klar gesetzt.
3. **Viewer statt Editor**: Der Pano-Viewer zeigt Daten und reagiert auf Interaktion, aber es fehlt ein geführter "Edit + Save" Workflow.
4. **Wenig Feedback**: Nach Speichern/Fehlern gibt es vor allem `console.log`, aber keine stabile UX-Feedback-Fläche.

## Empfohlene neue GUI-Struktur (3-Spalten-Editor)

### 1) Linke Spalte – Datensatz-Navigation
- Accordion/Liste aller BusinessViews.
- Unter jedem BusinessView: zugehörige Panoramen als klickbare Einträge.
- Aktionen pro Eintrag:
  - "Neu Panorama"
  - "Bearbeiten"
  - "Duplizieren" (optional)
  - "Löschen" (später)

**Nutzen:** schnelle Navigation, klare Auswahl des aktiven Datensatzes.

### 2) Mitte – Pano Stage (interaktiv)
- Großer StreetView-Canvas als primäre Arbeitsfläche.
- Kompakte Overlay-Controls:
  - Links/Rechts drehen
  - Pitch hoch/runter
  - Zoom +/-
  - Reset POV
- Optionaler Modus-Schalter:
  - "Map wählen" (Position aus Karte übernehmen)
  - "Pano feinjustieren" (nur POV)

**Nutzen:** Anwender arbeitet direkt im visuellen Kontext statt in Textfeldern.

### 3) Rechte Spalte – Eigenschaften + Speichern
- Formularfelder als strukturierte Sektionen:
  - **Standort**: Position, Pano-ID
  - **Kamera**: Heading, Pitch, Zoom
  - **Metadaten**: Titel, Reihenfolge, Verknüpfung BusinessView
- Sticky Action Bar unten:
  - "Änderungen speichern"
  - "Neu anlegen"
  - "Verwerfen"
- Statusindikator:
  - "Nicht gespeichert" / "Gespeichert" / "Fehler"

**Nutzen:** sichere Dateneingabe und klarer Commit-Punkt.

## Interaktionsmodell (wichtig für Steuerbarkeit + Speichern)

### A) Draft-State im Frontend
- Ein zentrales `editorState`-Objekt halten:
  - `selectedBusinessViewUid`
  - `selectedPanoramaUid`
  - `draft.position`, `draft.heading`, `draft.pitch`, `draft.zoom`, `draft.panoId`
  - `isDirty`
- Jede Panorama-Interaktion (`pov_changed`, `position_changed`, `zoom_changed`) schreibt in `editorState`.
- UI-Felder werden aus `editorState` gerendert (nicht umgekehrt).

### B) Explizite Save-Entscheidung
- `selectedPanoramaUid > 0` => `update`
- sonst => `create`
- Vor Save clientseitig validieren:
  - gültige Position
  - numerische POV-Werte
  - vorhandene BusinessView-Zuordnung

### C) Optimistisches UX-Feedback
- Während Save: Button disabled + Spinner.
- Bei Erfolg: Toast "Gespeichert", `isDirty=false`, ggf. UID aktualisieren.
- Bei Fehler: Fehlerbox mit Backend-Message (`message` aus JSON), keine stillen console-only Fehler.

## Konkreter Umsetzungsplan in 3 Iterationen

### Iteration 1 – UX-Basis
1. Layout in 3 Spalten im Modul-Template.
2. Ein "aktive Auswahl"-Modell einführen (BusinessView + Panorama).
3. Sichtbares Feedbackpanel für Erfolg/Fehler.

### Iteration 2 – Editor-State + Save-Fluss
1. `editorState` in `Tp3App` ergänzen.
2. `loadBusinessView(...)` beim Öffnen auch Panorama-UID/Felder sauber befüllen.
3. `savePanorama()` kapseln (create/update Entscheidung intern).
4. Dirty-State + Warnung bei Wechsel mit ungespeicherten Änderungen.

### Iteration 3 – Bedienkomfort
1. Keyboard-Shortcuts (z. B. Pfeile drehen, `Ctrl+S` speichern).
2. Undo/Reset auf letzte gespeicherte Version.
3. Mini-Preview der Panorama-Reihenfolge (drag & drop optional, später).

## Warum das zu eurem Backend passt
- `dispatchAction()` in `JsonResponseHandler` deckt `create/read/update` bereits ab.
- Die Sortierlogik (`sortAction`) existiert und kann in der neuen linken Liste direkt weitergenutzt werden.
- Das Backend muss dafür nicht grundlegend geändert werden; Schwerpunkt liegt auf einem robusten Frontend-State und einem klaren Save-Workflow.

## Minimaler technischer Feinschliff (ohne Architekturbruch)
1. Einheitliche Datenquelle: Felder immer aus `editorState` setzen.
2. Bei "Bearbeiten" die `panoramas[uid]` zuverlässig setzen.
3. Ein zentrales `renderEditorState()` statt verstreuter DOM-Schreibzugriffe.
4. Standardisierte API-Fehlerbehandlung (HTTP + JSON `success`).

## Fazit
Kurz gesagt: **vom Viewer zum Editor**.
Mit einem klaren 3-Spalten-Layout, zentralem Draft-State und explizitem Save-Flow wird das Pano zuverlässig steuerbar und das Ergebnis sicher speicherbar – ohne euer funktionierendes Backend neu zu bauen.
