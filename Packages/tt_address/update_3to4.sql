

update  tt_content SET pi_flexform = CONCAT('<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="sDEF">
            <language index="lDEF">
             <field index="singleRecords">'
              SUBSTRING_INDEX(SUBSTRING_INDEX(pi_flexform, 'index="singleRecords">', -1), '</field>', 1)
              '
              </field>
                <field index="groupSelection">
                    <value index="vDEF"></value>
                </field>
                <field index="combination">
                    <value index="vDEF">0</value>
                </field>
                <field index="sortBy">
                    <value index="vDEF">default</value>
                </field>
                <field index="sortOrder">
                    <value index="vDEF">ASC</value>
                </field>
                <field index="pages">
                    <value index="vDEF"></value>
                </field>
                <field index="recursive">
                    <value index="vDEF"></value>
                </field>
                <field index="settings.singleRecords">
                    <value index="vDEF">718</value>
                </field>
                <field index="settings.groups">
                    <value index="vDEF"></value>
                </field>
                <field index="settings.groupsCombination">
                    <value index="vDEF">0</value>
                </field>
                <field index="settings.sortBy">
                    <value index="vDEF">default</value>
                </field>
                <field index="settings.sortOrder">
                    <value index="vDEF">ASC</value>
                </field>
                <field index="settings.pages">
                    <value index="vDEF"></value>
                </field>
                <field index="settings.recursive">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
        <sheet index="sDISPLAY">
            <language index="lDEF">
                <field index="templateFile">
                    <value index="vDEF">default</value>
                </field>
                <field index="settings.displayMode">
                    <value index="vDEF">single</value>
                </field>
                <field index="settings.hidePagination">
                    <value index="vDEF">0</value>
                </field>
                <field index="settings.paginate.itemsPerPage">
                    <value index="vDEF"></value>
                </field>
                <field index="settings.singlePid">
                    <value index="vDEF"></value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>') ,  list_type = "ttaddress_listview" where list_type like "tt_address_pi1";



select tt_address.*, SUBSTRING_INDEX(SUBSTRING_INDEX(flexform, '<value index="vDEF">', -1), '</value>', 1) as tt_address_uid from (
select SUBSTRING_INDEX(SUBSTRING_INDEX(pi_flexform, 'index="singleRecords">', -1), '</field>', 1) as flexform, pid from tt_content  where list_type like "tt_address_pi1"
) as bb_content
left join tt_address on tt_address.uid = SUBSTRING_INDEX(SUBSTRING_INDEX(flexform, '<value index="vDEF">', -1), '</value>', 1)
left join pages on pages.uid = bb_content.pid
