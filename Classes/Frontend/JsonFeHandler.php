<?php

declare(strict_types=1);

namespace Tp3\Tp3Businessview\Frontend;

use Doctrine\DBAL\ParameterType;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\JsonResponse;

final class JsonFeHandler
{
    private const TABLE_BUSINESSVIEW = 'tx_tp3businessview_domain_model_tp3businessview';
    private const TABLE_PANORAMA = 'tx_tp3businessview_domain_model_panoramas';
    private const TABLE_ADDRESS = 'tt_address';
    private const TABLE_BUSINESSVIEW_PANORAMA_MM = 'tx_tp3businessview_domain_model_panoramas_mm';
    private const TABLE_BUSINESSVIEW_ADDRESS_MM = 'tx_tp3businessview_domain_model_tp3businessview_mm';

    private const FIELD_PANORAMA_PARENT = 'tp3businessviews';
    private const FIELD_BUSINESSVIEW_ADDRESS = 'contact';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $businessViewUid = (int)($queryParams['businessView'] ?? $queryParams['businessview'] ?? 0);
        $panoramaUid = (int)($queryParams['panorama'] ?? 0);
        $pid = (int)($queryParams['pid'] ?? 0);

        if ($businessViewUid > 0) {
            return $this->loadByBusinessViewUid($businessViewUid);
        }

        if ($panoramaUid > 0) {
            return $this->loadByPanoramaUid($panoramaUid);
        }

        if ($pid > 0) {
            return $this->loadFirstByPid($pid);
        }

        return new JsonResponse([
            'success' => false,
            'message' => 'Missing businessView, panorama or pid parameter',
        ], 400);
    }

    private function loadByPanoramaUid(int $panoramaUid): ResponseInterface
    {
        $panorama = $this->findPanoramaRowByUid($panoramaUid);
        if (!$panorama) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Panorama not found',
            ], 404);
        }

        $businessViewUid = (int)($panorama[self::FIELD_PANORAMA_PARENT] ?? 0);
        if ($businessViewUid <= 0) {
            $businessViewUid = $this->findBusinessViewUidByPanoramaUid($panoramaUid);
        }

        if ($businessViewUid <= 0) {
            return new JsonResponse([
                'success' => true,
                'businessview' => [],
                'panoramas' => [$this->normalizePanoramaRow($panorama)],
                'selectedPanorama' => $panorama ? $this->normalizePanoramaRow($panorama) : null,
                'settings' => [],
            ]);
        }

        return $this->buildBusinessViewResponse($businessViewUid, $panoramaUid);
    }

    private function loadByBusinessViewUid(int $businessViewUid): ResponseInterface
    {
        return $this->buildBusinessViewResponse($businessViewUid, null);
    }

    private function loadFirstByPid(int $pid): ResponseInterface
    {
        $queryBuilder = $this->createQueryBuilder(self::TABLE_BUSINESSVIEW);
        $row = $queryBuilder
            ->select('*')
            ->from(self::TABLE_BUSINESSVIEW)
            ->where(
                $queryBuilder->expr()->eq(
                    'pid',
                    $queryBuilder->createNamedParameter($pid, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'deleted',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'hidden',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->orderBy('sorting', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        if (!$row) {
            return new JsonResponse([
                'success' => false,
                'message' => 'No business view found for pid',
            ], 404);
        }

        return $this->buildBusinessViewResponse((int)$row['uid'], null);
    }

    private function buildBusinessViewResponse(int $businessViewUid, ?int $selectedPanoramaUid): ResponseInterface
    {
        $businessViewRow = $this->findBusinessViewRowByUid($businessViewUid);
        if (!$businessViewRow) {
            return new JsonResponse([
                'success' => false,
                'message' => 'BusinessView not found',
            ], 404);
        }

        $addressRow = null;
        $addressUid = $this->findAddressUidByBusinessViewUid($businessViewUid);
        if ($addressUid <= 0) {
            $addressUid = (int)($businessViewRow[self::FIELD_BUSINESSVIEW_ADDRESS] ?? 0);
        }
        if ($addressUid > 0) {
            $addressRow = $this->findAddressRowByUid($addressUid);
        }

        $panoramaRows = $this->findPanoramaRows($businessViewUid);
        $selectedPanorama = null;

        if ($selectedPanoramaUid > 0) {
            foreach ($panoramaRows as $panoramaRow) {
                if ((int)$panoramaRow['uid'] === $selectedPanoramaUid) {
                    $selectedPanorama = $panoramaRow;
                    break;
                }
            }
        }

        if ($selectedPanorama === null && !empty($panoramaRows)) {
            $selectedPanorama = $panoramaRows[0];
        }

            foreach ($panoramaRows as $row){
                $panoramas[] = $this->normalizePanoramaRow($row);
            }
        return new JsonResponse([
            'success' => true,
            'businessview' => [
                $this->normalizeBusinessViewRow($businessViewRow, $addressRow),
            ],
            'panoramas' => $panoramas ,
            'selectedPanorama' => $selectedPanorama ? $this->normalizePanoramaRow($selectedPanorama) : null,
        ]);
    }

    private function findBusinessViewRowByUid(int $uid): ?array
    {
        return $this->findRowByUid(self::TABLE_BUSINESSVIEW, $uid);
    }

    private function findPanoramaRowByUid(int $uid): ?array
    {
        return $this->findRowByUid(self::TABLE_PANORAMA, $uid);
    }

    private function findAddressRowByUid(int $uid): ?array
    {
        return $this->findRowByUid(self::TABLE_ADDRESS, $uid);
    }

    private function findRowByUid(string $table, int $uid): ?array
    {
        $queryBuilder = $this->createQueryBuilder($table);

        $row = $queryBuilder
            ->select('*')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($uid, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'deleted',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'hidden',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return $row ?: null;
    }
    private function findPanoramaRows(int $businessViewUid): array
    {
        $queryBuilder = $this->createQueryBuilder(self::TABLE_PANORAMA);

        $rows = $queryBuilder
            ->select('p.*', 'mm.uid_local AS mm_businessview_uid')
            ->from(self::TABLE_PANORAMA, 'p')
            ->innerJoin(
                'p',
                self::TABLE_BUSINESSVIEW_PANORAMA_MM,
                'mm',
                'mm.uid_local = p.uid AND mm.uid_foreign = ' .
                $queryBuilder->createNamedParameter($businessViewUid, ParameterType::INTEGER)
            )
            ->where(
                $queryBuilder->expr()->eq(
                    'p.deleted',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'p.hidden',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->orderBy('mm.sorting', 'ASC')
            ->addOrderBy('p.sorting', 'ASC')
            ->addOrderBy('p.uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        if (!empty($rows)) {
            return $rows;
        }

        // Fallback for legacy direct-field assignments without MM relation.
        $fallbackQueryBuilder = $this->createQueryBuilder(self::TABLE_PANORAMA);
        return $fallbackQueryBuilder
            ->select('*')
            ->from(self::TABLE_PANORAMA)
            ->where(
                $fallbackQueryBuilder->expr()->eq(
                    self::FIELD_PANORAMA_PARENT,
                    $fallbackQueryBuilder->createNamedParameter($businessViewUid, ParameterType::INTEGER)
                ),
                $fallbackQueryBuilder->expr()->eq(
                    'deleted',
                    $fallbackQueryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $fallbackQueryBuilder->expr()->eq(
                    'hidden',
                    $fallbackQueryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->orderBy('sorting', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function findPanoramaRowsByBusinessViewUid(int $businessViewUid): array
    {
        $queryBuilder = $this->createQueryBuilder(self::TABLE_PANORAMA);

        $rows = $queryBuilder
            ->select('p.*', 'mm.uid_local AS mm_businessview_uid')
            ->from(self::TABLE_PANORAMA, 'p')
            ->innerJoin(
                'p',
                self::TABLE_BUSINESSVIEW_PANORAMA_MM,
                'mm',
                'mm.uid_foreign = p.uid AND mm.uid_local = ' .
                $queryBuilder->createNamedParameter($businessViewUid, ParameterType::INTEGER)
            )
            ->where(
                $queryBuilder->expr()->eq(
                    'p.deleted',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $queryBuilder->expr()->eq(
                    'p.hidden',
                    $queryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->orderBy('mm.sorting', 'ASC')
            ->addOrderBy('p.sorting', 'ASC')
            ->addOrderBy('p.uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        if (!empty($rows)) {
            return $rows;
        }

        // Fallback for legacy direct-field assignments without MM relation.
        $fallbackQueryBuilder = $this->createQueryBuilder(self::TABLE_PANORAMA);
        return $fallbackQueryBuilder
            ->select('*')
            ->from(self::TABLE_PANORAMA)
            ->where(
                $fallbackQueryBuilder->expr()->eq(
                    self::FIELD_PANORAMA_PARENT,
                    $fallbackQueryBuilder->createNamedParameter($businessViewUid, ParameterType::INTEGER)
                ),
                $fallbackQueryBuilder->expr()->eq(
                    'deleted',
                    $fallbackQueryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                ),
                $fallbackQueryBuilder->expr()->eq(
                    'hidden',
                    $fallbackQueryBuilder->createNamedParameter(0, ParameterType::INTEGER)
                )
            )
            ->orderBy('sorting', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function findBusinessViewUidByPanoramaUid(int $panoramaUid): int
    {
        $queryBuilder = $this->createQueryBuilder(self::TABLE_BUSINESSVIEW_PANORAMA_MM);

        $uid = $queryBuilder
            ->select('uid_local')
            ->from(self::TABLE_BUSINESSVIEW_PANORAMA_MM)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid_foreign',
                    $queryBuilder->createNamedParameter($panoramaUid, ParameterType::INTEGER)
                )
            )
            ->orderBy('sorting_foreign', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchOne();

        return (int)$uid;
    }

    private function findAddressUidByBusinessViewUid(int $businessViewUid): int
    {
        $queryBuilder = $this->createQueryBuilder(self::TABLE_BUSINESSVIEW_ADDRESS_MM);

        $uid = $queryBuilder
            ->select('uid_foreign')
            ->from(self::TABLE_BUSINESSVIEW_ADDRESS_MM)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid_local',
                    $queryBuilder->createNamedParameter($businessViewUid, ParameterType::INTEGER)
                )
            )
            ->orderBy('sorting', 'ASC')
            ->addOrderBy('uid', 'ASC')
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchOne();

        return (int)$uid;
    }

    private function normalizeBusinessViewRow(array $row, ?array $addressRow): array
    {
        return [
            'uid' => (int)($row['uid'] ?? 0),
            'pid' => (int)($row['pid'] ?? 0),
            'title' => (string)($row['title'] ?? ''),
            'heading' => (string)($row['heading'] ?? ''),
            'intro' => (string)($row['intro'] ?? ''),
            'description' => (string)($row['description'] ?? ''),
            'contact' => $addressRow ? $this->normalizeAddressRow($addressRow) : null,
        ];
    }

    private function normalizePanoramaRow(array $row): array
    {
        $businessViewUid = (int)($row['mm_businessview_uid'] ?? $row[self::FIELD_PANORAMA_PARENT] ?? 0);

        return [
            'uid' => (int)($row['uid'] ?? 0),
            'pid' => (int)($row['pid'] ?? 0),
            'heading' => (string)($row['heading'] ?? ''),
            'pitch' => (string)($row['pitch'] ?? ''),
            'zoom' => (string)($row['zoom'] ?? ''),
            'position' => (string)($row['position'] ?? ''),
            'panoId' => (string)($row['pano_id'] ?? ''),
            'businessViewUid' => $businessViewUid,
        ];
    }

    private function normalizeAddressRow(array $row): array
    {
        return [
            'uid' => (int)($row['uid'] ?? 0),
            'name' => (string)($row['name'] ?? ''),
            'address' => (string)($row['address'] ?? ''),
            'zip' => (string)($row['zip'] ?? ''),
            'city' => (string)($row['city'] ?? ''),
            'phone' => (string)($row['phone'] ?? ''),
            'mobile' => (string)($row['mobile'] ?? ''),
            'email' => (string)($row['email'] ?? ''),
            'website' => (string)($row['www'] ?? $row['website'] ?? ''),
        ];
    }

    private function extractSettingsFromDescription(string $description): array
    {
        if ($description === '') {
            return [];
        }

        if (!preg_match('/<!--tp3bv-settings:([A-Za-z0-9+\/=]+)-->/', $description, $matches)) {
            return [];
        }

        $encoded = (string)($matches[1] ?? '');
        if ($encoded === '') {
            return [];
        }

        $json = base64_decode($encoded, true);
        if ($json === false || $json === '') {
            return [];
        }

        $settings = json_decode($json, true);
        return is_array($settings) ? $settings : [];
    }

    private function createQueryBuilder(string $table): \TYPO3\CMS\Core\Database\Query\QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
