ALTER TABLE themes
    ADD COLUMN IF NOT EXISTS media varchar(255);

ALTER TABLE plugins
    ADD COLUMN IF NOT EXISTS media varchar(255);

ALTER TABLE themes
    ALTER COLUMN date SET default now();

ALTER TABLE plugins
    ALTER COLUMN date SET default now();

ALTER TABLE themes
    RENAME COLUMN versiontheme TO version;

ALTER TABLE plugins
    RENAME COLUMN versionplugin TO version;

ALTER TABLE themes
    RENAME COLUMN versionpluxml TO pluxml;

ALTER TABLE plugins
    RENAME COLUMN versionpluxml TO pluxml;

CREATE TABLE pluxml (
    id int(11) NOT NULL auto_increment,
    version varchar(100) NOT NULL,
    published date NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO pluxml(version,published) VALUES
    ('5.3.1','2014-03-13'),
    ('5.4','2015-07-13'),
    ('5.5','2016-04-04'),
    ('5.6','2017-04-05'),
    ('5.7','2018-12-10'),
    ('5.8','2020-01-05'),
    ('5.8.1','2020-01-07'),
    ('5.8.2','2020-02-10'),
    ('5.8.3','2020-05-22'),
    ('5.8.4','2020-09-11'),
    ('5.8.5','2020-02-15'),
    ('5.8.6','2021-02-15'),
    ('5.8.7','2021-06-03'),
    ('5.8.9','2022-08-04')
;
