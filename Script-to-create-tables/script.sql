-- criando tabela domains
CREATE TABLE IF NOT EXISTS domains (domain VARCHAR(50) NOT NULL, PRIMARY KEY (domain) );
-- criando tabela forwardings
CREATE TABLE IF NOT EXISTS forwardings (source VARCHAR(80) NOT NULL, destination TEXT NOT NULL, PRIMARY KEY (source) );
-- criando tabela transport
CREATE TABLE IF NOT EXISTS transport ( domain VARCHAR(128) NOT NULL DEFAULT '', transport VARCHAR(128) NOT NULL DEFAULT '', UNIQUE KEY domain (domain) );

-- criando ftpusers
CREATE TABLE IF NOT EXISTS ftpusers (
nome varchar(255) NOT NULL DEFAULT 'Nome',
login varchar(20) NOT NULL,
senha varchar(20) NOT NULL,
uid int(10) NOT NULL AUTO_INCREMENT,
gid int(10) DEFAULT NULL,
ativo char(1) NOT NULL DEFAULT 's',
dir varchar(255) NOT NULL,
shell varchar(255) NOT NULL,
email varchar(255) DEFAULT NULL,
PRIMARY KEY (login),
KEY login (login),
KEY uid (uid) );

-- criando tabela ftpgroups
CREATE TABLE IF NOT EXISTS ftpgroups(
groupname varchar(20) NOT NULL,
gid int(10) NOT NULL,
members varchar(255) DEFAULT NULL,
PRIMARY KEY (groupname)
);

-- criando tabela de root_users
CREATE TABLE IF NOT EXISTS root_users (
id int(10) NOT NULL AUTO_INCREMENT,
Login_root varchar(255) NOT NULL,
senha varchar(100) NOT NULL,
PRIMARY KEY (id),
KEY Login_root (Login_root),
KEY senha (senha) );