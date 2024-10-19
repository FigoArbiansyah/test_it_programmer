<?php

$sqlSkorKPI = "SELECT 
    karyawan AS nama,
    SUM(CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END) AS target_sales,
    SUM(CASE WHEN aktual < deadline AND kpi = 'Sales' THEN 1 ELSE 0 END) AS aktual_sales,
    (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Sales' THEN 1 ELSE 0 END
    ) / NULLIF(SUM(
        CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END
    ), 0)) * 100 AS pencapaian_sales,
    50 as bobot_sales,
    (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Sales' THEN 1 ELSE 0 END
    ) - NULLIF(SUM(
        CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END
    ), 0)) * 7 as late_sales,
    ((50) + (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Sales' THEN 1 ELSE 0 END
    ) - NULLIF(SUM(
        CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END
    ), 0)) * 7) as total_bobot_sales,
    SUM(
        CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END
    ) AS target_report,
    SUM(
        CASE WHEN aktual < deadline AND kpi = 'Report' THEN 1 ELSE 0 END
    ) AS aktual_report,
    (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Report' THEN 1 ELSE 0 END
    ) / NULLIF(SUM(
        CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END
    ), 0)) * 100 AS pencapaian_report,
    50 as bobot_report,
    (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Report' THEN 1 ELSE 0 END
    ) - NULLIF(SUM(
        CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END
    ), 0)) * 7 as late_report,
    ((50) + (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Report' THEN 1 ELSE 0 END
    ) - NULLIF(SUM(
        CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END
    ), 0)) * 7) as total_bobot_report,
    ((50) + (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Sales' THEN 1 ELSE 0 END
    ) - NULLIF(SUM(
        CASE WHEN kpi = 'Sales' THEN 1 ELSE 0 END
    ), 0)) * 7) + ((50) + (SUM(
        CASE WHEN aktual < deadline AND kpi = 'Report' THEN 1 ELSE 0 END
    ) - NULLIF(SUM(
        CASE WHEN kpi = 'Report' THEN 1 ELSE 0 END
    ), 0)) * 7) as skor_kpi
FROM table_kpi_marketing tkm
GROUP BY karyawan";

$sqlTaskOnTimeAndLate = "select 
	SUM(CASE WHEN aktual < deadline AND (kpi = 'Sales' or kpi = 'Report') THEN 1 ELSE 0 END) AS total_task_ontime,
	SUM(CASE WHEN aktual > deadline AND (kpi = 'Sales' or kpi = 'Report') THEN 1 ELSE 0 END) AS total_task_late
from table_kpi_marketing tkm";

?>