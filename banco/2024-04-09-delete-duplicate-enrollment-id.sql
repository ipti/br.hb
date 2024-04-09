-- Criar a tabela temporária para armazenar os IDs a serem excluídos
CREATE TEMPORARY TABLE tmp_hemoglobin_to_delete (id INT);

-- Inserir os IDs dos registros a serem excluídos na tabela temporária
INSERT INTO tmp_hemoglobin_to_delete
SELECT h.id
FROM hemoglobin h
JOIN term t ON t.id = h.agreed_term
JOIN enrollment e ON e.id = t.enrollment
WHERE e.id IN (
    SELECT e.id
    FROM hemoglobin h
    JOIN term t ON t.id = h.agreed_term
    JOIN enrollment e ON e.id = t.enrollment
    GROUP BY e.id
    HAVING COUNT(*) > 1
)
AND (t.id, h.id) NOT IN (
    SELECT t.id, MAX(h.id)
    FROM hemoglobin h
    JOIN term t ON t.id = h.agreed_term
    JOIN enrollment e ON e.id = t.enrollment
    WHERE e.id IN (
        SELECT e.id
        FROM hemoglobin h
        JOIN term t ON t.id = h.agreed_term
        JOIN enrollment e ON e.id = t.enrollment
        GROUP BY e.id
        HAVING COUNT(*) > 1
    )
    GROUP BY t.id
);

-- Excluir os registros da tabela 'hemoglobin' com base nos IDs armazenados na tabela temporária
DELETE FROM hemoglobin
WHERE id IN (SELECT id FROM tmp_hemoglobin_to_delete);

-- Limpar a tabela temporária
DROP TEMPORARY TABLE IF EXISTS tmp_hemoglobin_to_delete;