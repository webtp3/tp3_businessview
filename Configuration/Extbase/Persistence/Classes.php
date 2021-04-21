<?php
declare(strict_types = 1);
/*
 * config.tx_extbase{
  persistence {
    classes {
      Tp3\Tp3Businessview\Domain\Model\Panoramas {
        mapping {
          tableName = tx_tp3businessview_domain_model_panoramas
          recordType = Tx_Tp3Businessview_Panoramas
          columns {
            tp3businessviews.mapOnProperty = uid_local
            sorting.mapOnProperty = sorting

          }
        }

      }
      TYPO3\TtAddress\Domain\Model\Address{
        subclasses {
          0 = Tp3\Tp3Businessview\Domain\Model\BusinessAdress
        }
      }
      Tp3\Tp3Businessview\Domain\Model\BusinessAdress {
        mapping {
          tableName = tt_address
          recordType = 0
          columns {
            cid.mapOnProperty = cid
            sorting.mapOnProperty = sorting
            tp3businessview.mapOnProperty = uid_foreign
            googleplus.mapOnProperty = googleplus
          }
        }

      }
      Tp3\Tp3Businessview\Domain\Model\Tp3Businessview {
        mapping {
          tableName = tx_tp3businessview_domain_model_tp3businessview
          recordType = Tx_Tp3Businessview_Tp3Businessview
          columns {
            panoramas.mapOnProperty = uid_foreign
            contact.mapOnProperty = uid_local
            sorting.mapOnProperty = sorting
            description.mapOnProperty = description

          }
        }
        subclasses {
          0 = Tp3\Tp3Businessview\Domain\Model\BusinessAdress
          Tx_Tp3Businessview_Panoramas = Tp3\Tp3Businessview\Domain\Model\Panoramas

        }
      }
    }
  }
}
 */
if (class_exists(\Tp3\Tp3Businessview\Domain\Model\BusinessAdress::class)) {

    return [

        \Tp3\Tp3Businessview\Domain\Model\BusinessAdress::class => [
            'tableName' => 'tt_address',
            'properties' => [
                'uid_foreign' => [
                    'fieldName' => 'tp3businessview'
                ],
                'cid' => [
                    'fieldName' => 'cid'
                ],
            ],
        ],
    ];
}
else{
    return [


    ];
}
