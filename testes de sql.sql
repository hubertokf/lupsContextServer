SELECT sensor_id
FROM relcontextointeresse AS rci

WHERE contextointeresse_id IN (
	SELECT contextointeresse_id from permissoes as p where p.usuario_id = X
)








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