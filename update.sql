CREATE TABLE permissoes
(
  permissao_id integer NOT NULL,
  usuario_id integer NOT NULL,
  contextointeresse_id integer,
  sensor_id integer,
  ambiente_id integer,
  regra_id integer,
  CONSTRAINT permissoes_pkey PRIMARY KEY (permissao_id)
)
WITH (
  OIDS=FALSE
);

CREATE SEQUENCE permissao_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE permissao_id_seq
  OWNER TO huberto;


ALTER TABLE permissoes
  ADD CONSTRAINT permissoes_ambiente_fk FOREIGN KEY (ambiente_id)
      REFERENCES ambiente (ambiente_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE permissoes
  ADD CONSTRAINT permissoes_contextointeresse_fk FOREIGN KEY (contextointeresse_id)
      REFERENCES contextointeresse (contextointeresse_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE permissoes
  ADD CONSTRAINT permissoes_regras_fk FOREIGN KEY (regra_id)
      REFERENCES regras (regra_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE permissoes
  ADD CONSTRAINT permissoes_sensor_fk FOREIGN KEY (sensor_id)
      REFERENCES sensor (sensor_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE permissoes
  ADD CONSTRAINT permissoes_usuario_fk FOREIGN KEY (usuario_id)
      REFERENCES usuario (usuario_id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE permissoes ALTER COLUMN permissao_id SET DEFAULT nextval('permissao_id_seq'::regclass);

ALTER TABLE contextointeresse ADD COLUMN publico boolean;
ALTER TABLE contextointeresse ALTER COLUMN publico SET NOT NULL;
ALTER TABLE contextointeresse ALTER COLUMN publico SET DEFAULT true;
