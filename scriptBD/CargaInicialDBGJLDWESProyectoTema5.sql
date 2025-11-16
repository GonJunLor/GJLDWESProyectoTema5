/**
 * Author:  gonzalo.junlor
 * Created: 16 nov. 2025
 * Script de carga incial de base de datos
 */

use DBGJLDWESProyectoTema5;

insert into T02_Departamento values
        ('INF','Departamento de informatica.',now(),1235.5,null),
        ('AUT','Departamento de automocion.',now(),5235.8,null),
        ('ELE','Departamento de electricidad.',now(),2275.1,null),
        ('MAT','Departamento de matematicas.',now(),735.2,null),
        ('ING','Departamento de ingles.',now(),235.9,now()
);

insert into Usuario values ('admin','d6ed7eb369f21acd3d3d66a96de946cc2b514e4279827bf8a7ca9d7005514b27');

