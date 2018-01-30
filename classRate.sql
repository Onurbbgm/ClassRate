create table professores (
     cod_professor int not null AUTO_INCREMENT,
     nome_professor varchar(100) not null,
     media_avaliacao float(3),     
     cod_universidade int not null,
     constraint pk_professores primary key (cod_professor)
);

create table universidades(
	cod_universidade int not null AUTO_INCREMENT,
	nome_universidade varchar(100) not null,
	apelido_universidade varchar(10) not null,
	constraint pk_universidades primary key (cod_universidade)
);

create table cursos(
	cod_curso int not null AUTO_INCREMENT,
	nome_curso varchar(100) not null,
	constraint pk_cursos primary key (cod_curso)
);

create table professores_cursos(
	cod_professor int not null,
	cod_curso int not null,
	constraint pk_professores_cursos primary key (cod_professor, cod_curso)
);

create table universidades_cursos(
	cod_universidade int not null,
	cod_curso int not null,
	constraint pk_universidades_cursos primary key (cod_universidade, cod_curso)
);

create table disciplinas(
	cod_disciplina int not null AUTO_INCREMENT,
	nome_disciplina varchar(50) not null,
	constraint pk_disciplinas primary key (cod_disciplina)
);

create table disciplinas_professores(
	cod_disciplina int not null,
	cod_professor int not null,
	constraint pk_disciplinas_professores primary key (cod_disciplina, cod_professor)
);

create table cursos_disciplinas(
	cod_curso int not null,
	cod_disciplina int not null,
	constraint pk_cursos_disciplinas primary key (cod_curso, cod_disciplina)
);

create table avaliacoes(
	cod_avaliacao int not null AUTO_INCREMENT,
	notaGeral smallint not null,
	nivelDifi smallint not null,
	repetirProf boolean not null,
	presenca smallint not null,
	comentario varchar(200) not null,
	passou smallint,
	notaRecebida float(3),
	cod_curso int not null,
	cod_disciplina int not null,
	cod_professor int not null,
	cod_user int not null,
	constraint pk_avaliacoes primary key (cod_avaliacao)
);

create table tags(
	cod_tag int not null AUTO_INCREMENT,
	nome_tag varchar(30) not null,
	constraint pk_tags primary key (cod_tag)
);

create table tags_professores_avaliacoes(
	cod_tag int not null,
	cod_professor int not null,
	cod_avaliacao int not null,
	constraint pk_tags_professores_avaliacoes primary key (cod_tag, cod_professor, cod_avaliacao)
);



create table users(
	cod_user int not null AUTO_INCREMENT,
	nome_user varchar(50) not null,
	email_user varchar(70) not null,
	passw_user varchar(32) not null,
	cod_universidade int not null,
	cod_curso int not null,
	constraint pk_users primary key (cod_user)
);