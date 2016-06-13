ALTER TABLE relcontextointeresse DROP COLUMN regra_id;
ALTER TABLE relcontextointeresse ADD COLUMN ativaregra BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE contextointeresse ADD COLUMN regra_id INTEGER;
ALTER TABLE contextointeresse ADD CONSTRAINT regra_contextointeresse_fk FOREIGN KEY (regra_id)
      REFERENCES regras (regra_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE SET NULL;


ALTER TABLE permissoes ADD COLUMN podeEditar BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE permissoes ADD COLUMN recebeEmail BOOLEAN NOT NULL DEFAULT FALSE;