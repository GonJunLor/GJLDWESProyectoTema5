/**
 * Author:  gonzalo.junlor
 * Created: 16 nov. 2025
 * Script de creación de base de datos
 */
create database if not exists DBGJLDWESProyectoTema5;

create table if not exists DBGJLDWESProyectoTema5.T02_Departamento(
    T02_CodDepartamento varchar(3) primary key,
    T02_DescDepartamento varchar(255),
    T02_FechaCreacionDepartamento datetime not null,
    T02_VolumenDeNegocio float null,
    T02_FechaBajaDepartamento datetime null
)engine=innodb;

create table if not exists DBGJLDWESProyectoTema5.Usuario(
    nombre varchar(100) not null primary key,
    contrasena varchar(64) not null
)engine=innodb;

create user if not exists 'userGJLDWESProyectoTema5'@'%' identified by '5813Libro-Puro';
-- create user if not exists 'userGJLDWESProyectoTema5'@'%' identified by 'paso';

grant all privileges on *.* to 'userGJLDWESProyectoTema5'@'%' with grant option;

flush privileges;