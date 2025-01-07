-- Add indexes for frequently joined columns
ALTER TABLE Jobs ADD INDEX idx_job_category_id (job_category_id);
ALTER TABLE Jobs ADD INDEX idx_job_type_id (job_type_id);
ALTER TABLE Jobs ADD INDEX idx_publish_status (publish_status);
ALTER TABLE Jobs ADD INDEX idx_deleted (deleted);

-- Add indexes for sorting
ALTER TABLE Jobs ADD INDEX idx_sort_order_id (sort_order, id);

-- Add full-text indexes for text search columns
ALTER TABLE Jobs ADD FULLTEXT INDEX idx_job_search (
    name,
    description,
    detail,
    business_skill,
    knowledge,
    location,
    activity,
    salary_statistic_group,
    salary_range_remarks,
    restriction,
    remarks
);


-- Rewrite Query Using FULLTEXT Search
SELECT
    Jobs.id AS `Jobs__id`,
    Jobs.name AS `Jobs__name`,
    Jobs.media_id AS `Jobs__media_id`,
    Jobs.job_category_id AS `Jobs__job_category_id`,
    Jobs.job_type_id AS `Jobs__job_type_id`,
    Jobs.description AS `Jobs__description`,
    Jobs.detail AS `Jobs__detail`,
    Jobs.business_skill AS `Jobs__business_skill`,
    Jobs.knowledge AS `Jobs__knowledge`,
    Jobs.location AS `Jobs__location`,
    Jobs.activity AS `Jobs__activity`,
    Jobs.academic_degree_doctor AS `Jobs__academic_degree_doctor`,
    Jobs.academic_degree_master AS `Jobs__academic_degree_master`,
    Jobs.academic_degree_professional AS `Jobs__academic_degree_professional`,
    Jobs.academic_degree_bachelor AS `Jobs__academic_degree_bachelor`,
    Jobs.salary_statistic_group AS `Jobs__salary_statistic_group`,
    Jobs.salary_range_first_year AS `Jobs__salary_range_first_year`,
    Jobs.salary_range_average AS `Jobs__salary_range_average`,
    Jobs.salary_range_remarks AS `Jobs__salary_range_remarks`,
    Jobs.restriction AS `Jobs__restriction`,
    Jobs.estimated_total_workers AS `Jobs__estimated_total_workers`,
    Jobs.remarks AS `Jobs__remarks`,
    Jobs.url AS `Jobs__url`,
    Jobs.seo_description AS `Jobs__seo_description`,
    Jobs.seo_keywords AS `Jobs__seo_keywords`,
    Jobs.sort_order AS `Jobs__sort_order`,
    Jobs.publish_status AS `Jobs__publish_status`,
    Jobs.version AS `Jobs__version`,
    Jobs.created_by AS `Jobs__created_by`,
    Jobs.created AS `Jobs__created`,
    Jobs.modified AS `Jobs__modified`,
    Jobs.deleted AS `Jobs__deleted`,
    JobCategories.id AS `JobCategories__id`,
    JobCategories.name AS `JobCategories__name`,
    JobCategories.sort_order AS `JobCategories__sort_order`,
    JobCategories.created_by AS `JobCategories__created_by`,
    JobCategories.created AS `JobCategories__created`,
    JobCategories.modified AS `JobCategories__modified`,
    JobCategories.deleted AS `JobCategories__deleted`,
    JobTypes.id AS `JobTypes__id`,
    JobTypes.name AS `JobTypes__name`,
    JobTypes.job_category_id AS `JobTypes__job_category_id`,
    JobTypes.sort_order AS `JobTypes__sort_order`,
    JobTypes.created_by AS `JobTypes__created_by`,
    JobTypes.created AS `JobTypes__created`,
    JobTypes.modified AS `JobTypes__modified`,
    JobTypes.deleted AS `JobTypes__deleted`
FROM jobs Jobs
    INNER JOIN job_categories JobCategories
        ON JobCategories.id = Jobs.job_category_id
        AND JobCategories.deleted IS NULL
    INNER JOIN job_types JobTypes
        ON JobTypes.id = Jobs.job_type_id
        AND JobTypes.deleted IS NULL
WHERE
    MATCH(Jobs.name, Jobs.description, Jobs.detail,
          Jobs.business_skill, Jobs.knowledge,
          Jobs.location, Jobs.activity, Jobs.salary_statistic_group, Jobs.salary_range_remarks,
          Jobs.restriction, Jobs.remarks)
    AGAINST('キャビンアテンダント' IN BOOLEAN MODE)
    AND Jobs.publish_status = 1
    AND Jobs.deleted IS NULL
GROUP BY Jobs.id
ORDER BY Jobs.sort_order DESC, Jobs.id DESC
LIMIT 50 OFFSET 0;

