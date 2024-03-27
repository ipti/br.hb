CREATE TEMPORARY TABLE TEMP_TBL
select min(id) from term t
group by t.campaign, t.enrollment
HAVING COUNT(1) > 1;


DELETE FROM term WHERE id in(
SELECT * from temp_tbl
);
