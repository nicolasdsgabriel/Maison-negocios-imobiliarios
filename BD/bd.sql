-- está faltando editar melhor o que cada variavel é

drop database if exists maison2;

create database if not exists maison2;

use maison2;

create table Imoveis(
	imID int not null primary key auto_increment, -- Atributo responsavel por salvar o ID do imovel.
	imDesc varchar(500), -- Atributo responsavel por salvar a Descrição do imovel, onde está a descrição que é um aglomerado de informações sobre o imovel
    imLocation varchar(300) not null, -- Atributo que recebe o endereço do imovel
    imCEP varchar(20) not null, -- Atributo que recebe o CEP do imovel
    tipo varchar(20) not null, -- Atributo que recebe o tipo do imovel, sendo este: Casa, Apartamento, Kitnet
    preco float not null, -- Atributo que recebe o valor do imovel
    qtdDormitorios int(10) not null, -- Atributo que recebe a quantidade de dormitorios que o imovel contém
    imOperacao varchar(20) not null, -- Atributo que recebe a operação do qual o imovel está salva, sendo para aluguel, compra ou todos.
    qtdGaragem int(10) not null, -- Atributo que recebe a quantidade de garagem que o imovel contém
    qtdCozinha int(10) not null,
    qtdLavanderia int(10) not null,
    qtdBanheiro int(10) not null,
    qtdSala int(10) not null,
    latitude float(50),
    longitude float(50),
    imTitulo varchar(100) not null,
    identificadorUnico varchar(150) not null -- Nome especifico unico, ou seja, não outro igual, para que podemos recuperar um imovel mais especifico.
);

create table Imoveis_img(
	imgID int not null primary key auto_increment,
    imgRef varchar(300) not null,
    imID int not null,
    data_upload DATETIME DEFAULT CURRENT_TIMESTAMP, -- Salva a data que o upload foi realizado
    IDuserUp INT NOT NULL, -- Recebe o identificador do usuário que realizou o upload
    foreign key (imID) references Imoveis(imID)
);

create table Cliente(
	clienteID int not null primary key auto_increment,
    clienteNome varchar(50) not null,
    clienteCPF varchar(14) not null,
    clienteEmail varchar(120) not null,
    clienteSenha varchar (25) not null,
    clienteTel varchar (14) not null,
    adm int not null -- se for 1 é adm, se for 0 é cliente
);

create table Catalogo(
	CatalogoID int not null auto_increment,
	imID int not null,
    clienteID int not null,
    deseja_contato varchar(10), 
    flagFav int(1) ,
    feito_contato varchar(10),
    primary key (CatalogoID, imID, clienteID),
    foreign key (imID) references Imoveis(imID),
    foreign key (clienteID) references Cliente(clienteID)
);

insert into Imoveis(imDesc, imLocation, imCEP, tipo, preco, imOperacao, qtdDormitorios, qtdGaragem)
	values ('Primeiro Imovel cadastrado', 'Rua são bento - 567','14502-890','casa', '200000.90', 'todos', '2', '1'),
    ('Segundo Imovel cadastrado', 'Rua paula - 777', '15666-908', 'apartamento', '250000.90', 'todos', '1', '2'),
    ('terceiro imovel', 'bento - 645', '13402-121', 'kitnet', '2502313213', 'compra', '3', '4'),
    ('Quarto imovel', 'Paulista - 125', '11000-000', 'casa', '232132.90', 'aluguel', '1', '1'),
    ('quinto imovel', 'araraquara - 000', '00652-982', 'kitnet', '2213213', 'aluguel', '4', '6'),
    ('sexto imovel', 'casa - 999', '21333-009', 'apartamento', '21313213.90', 'compra', '2', '1'),
    ('sete imovel', 'bola - 212', '90222-988', 'apartamento', '21313213', 'aluguel','1', '1'),
    ('oitavo imovel', 'quadrada - 231', '78999-999', 'casa', '2502313213', 'todos', '2', '1'),
    ('nono imovel', 'carrosel - 645', '54262-611', 'kitnet', '250239909', 'todos','4', '2'),
    ('decimo imovel', 'pitanga - 645', '21321-123', 'apartamento', '2502313.90', 'todos', '2', '1');

insert into Imoveis_img (imgRef, imID, IDuserUp)
	values('IMG/casa1.jpeg',1,1),
    ('IMG/casa2.jpeg',1,1),
    ('IMG/casa3.jpeg',1,1),
    ('IMG/casa1.jpeg',2,1),
    ('IMG/casa2.jpeg',2,1),
    ('IMG/casa3.jpeg',2,1),
     ('IMG/casa1.jpeg',3,1),
    ('IMG/casa2.jpeg',3,1),
    ('IMG/casa3.jpeg',3,1),
    ('IMG/casa1.jpeg',4,1),
    ('IMG/casa2.jpeg',4,1),
    ('IMG/casa3.jpeg',4,1),
    ('IMG/casa1.jpeg',5,1),
    ('IMG/casa2.jpeg',5,1),
    ('IMG/casa3.jpeg',5,1),
    ('IMG/casa1.jpeg',6,1),
    ('IMG/casa2.jpeg',6,1),
    ('IMG/casa3.jpeg',6,1),
    ('IMG/casa1.jpeg',7,1),
    ('IMG/casa2.jpeg',7,1),
    ('IMG/casa3.jpeg',7,1),
    ('IMG/casa1.jpeg',8,1),
    ('IMG/casa2.jpeg',8,1),
    ('IMG/casa3.jpeg',8,1),
    ('IMG/casa1.jpeg',9,1),
    ('IMG/casa2.jpeg',9,1),
    ('IMG/casa3.jpeg',9,1),
    ('IMG/casa1.jpeg',10,1),
    ('IMG/casa2.jpeg',10,1),
    ('IMG/casa3.jpeg',10,1);

insert into Cliente (clienteNome, clienteCPF, clienteEmail, clienteSenha, clienteTel, adm)
values ('Nicolas', '50494322861', 'nickgabriel.k@gmail.com', '11153025192', '16 993838132', 1);

select * from Catalogo;

