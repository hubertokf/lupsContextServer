SELECT sensor_id
FROM relcontextointeresse AS rci

WHERE contextointeresse_id IN (
	SELECT contextointeresse_id from permissoes as p where p.usuario_id = X
)


SELECT regra_id
FROM contextointeresse AS ci
WHERE contextointeresse_id IN (
	SELECT contextointeresse_id from permissoes as p where p.usuario_id = X
)


SELECT r.*
FROM regras as r

JOIN contextointeresse AS ci ON ci.regra_id = r.regra_id
INNER JOIN permissoes AS p ON ci.contextointeresse_id = p.contextointeresse_id

WHERE p.usuario_id = 6




SELECT *
FROM sensor as s

JOIN relcontextointeresse as rci ON  rci.sensor_id = s.sensor_id
INNER JOIN permissoes as p ON rci.contextointeresse_id = p.contextointeresse_id

WHERE p.usuario_id = 6


SELECT *
FROM ambiente as a

JOIN relcontextointeresse as rci ON  rci.sensor_id = s.sensor_id
INNER JOIN permissoes as p ON rci.contextointeresse_id = p.contextointeresse_id

WHERE p.usuario_id = 6




















SELECT *
FROM sensor AS s

inner JOIN permissoes AS p ON p.sensor_id = s.sensor_id
JOIN relcontextointeresse AS rci ON rci.contextointeresse_id = p.contextointeresse_id
JOIN contextointeresse AS ci ON ci.contextointeresse_id = rci.contextointeresse_id

WHERE rci.sensor_id = 5 OR p.sensor_id = 5






SELECT *
FROM usuario AS u

JOIN permissoes AS p ON p.usuario_id = u.usuario_id
JOIN contextointeresse AS ci ON ci.contextointeresse_id = p.contextointeresse_id
JOIN relcontextointeresse AS rci ON rci.contextointeresse_id = p.contextointeresse_id

WHERE rci.sensor_id = 5 OR p.sensor_id = 5