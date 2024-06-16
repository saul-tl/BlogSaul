Create database PortaFolio;
Use Portafolio;
Create table users_data (
	idUser int auto_increment primary key,
    nombre varchar(255) not null,
    apellidos varchar(255) not null,
    email varchar(255) not null,
    telefono varchar(255) not null,
    fecha_nacimiento date not null,
    direccion varchar(255),
    sexo enum('Masculino','Femenino') not null
);
Create table user_login(
	idLogin int auto_increment primary key,
    idUser int unique not null,
    usuario varchar(255) not null unique,
    password varchar(255) not null,
    rol enum('admin','user') not null,
    foreign key (idUser) references users_data(idUser)
);
Create table citas (
	idCita int auto_increment primary key,
    idUser int not null,
    fecha_cita date not null,
    motivo_cita text,
    foreign key (idUser) references users_data(idUser)
);
Create table noticias (
	idNoticia int auto_increment primary key,
    titulo varchar(255) not null unique,
    imagen varchar(255) not null, -- asumiendo ruta de archivo o url
    texto text not null,
    fecha date not null,
    idUser int not null,
    foreign key (idUser) references users_data(idUser) ON DELETE CASCADE
);
select * from user_login;
SELECT imagen FROM noticias;

DELETE FROM users_data WHERE idUser = 1;

-- Eliminar la clave foránea existente
ALTER TABLE noticias DROP FOREIGN KEY noticias_ibfk_1;

-- Agregar la clave foránea con ON DELETE CASCADE
ALTER TABLE noticias ADD CONSTRAINT noticias_ibfk_1
FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE;


-- Eliminar la clave foránea existente
ALTER TABLE citas DROP FOREIGN KEY citas_ibfk_1;

-- Agregar la clave foránea con ON DELETE CASCADE
ALTER TABLE citas ADD CONSTRAINT citas_ibfk_1
FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE;

-- Eliminar la clave foránea existente
ALTER TABLE user_login DROP FOREIGN KEY user_login_ibfk_1;

-- Agregar la clave foránea con ON DELETE CASCADE
ALTER TABLE user_login ADD CONSTRAINT user_login_ibfk_1
FOREIGN KEY (idUser) REFERENCES users_data(idUser) ON DELETE CASCADE;

ALTER TABLE users_data ADD CONSTRAINT email_unique UNIQUE (email);