#------------------------------------------------------------
# Database: OeuvreDArt
#------------------------------------------------------------

DROP DATABASE IF EXISTS OeuvreDArt;
CREATE DATABASE OeuvreDArt;
USE OeuvreDArt;

#------------------------------------------------------------
# Table: Artiste
#------------------------------------------------------------

CREATE TABLE Artiste(
    idArtiste            INT  AUTO_INCREMENT  NOT NULL,
    nomArtiste           VARCHAR (100) NOT NULL,
    prenomArtiste        VARCHAR (100),
    dateNaissanceArtiste DATE,
    CONSTRAINT Artiste_PK PRIMARY KEY (idArtiste)
)ENGINE=InnoDB;

INSERT INTO Artiste (nomArtiste, prenomArtiste, dateNaissanceArtiste) VALUES
('Van Gogh', 'Vincent', 18590330),
('De Vinci', 'Léonard', 14520415),
('Rembrandt', '', 16060715),
('Hugo', 'Victor', 18850522),
('Dali', 'Salvador', 19040511),
('Picasso', 'Pablo', 19730408),
('Monnet', 'Claude', 18401114),
('David', 'Jaques-louis', 17480830),
('Delacroix','Eugene',17980426),
('Buhot','Felix',18470709),
('Michel-Ange','', 14750306),
('Gian Lorenzo', 'Bernini', 15981207),
('Antokolski', 'Mark', 18401021),
('Ai Weiwei', 'Ai', 19570828),
('Othoniel', 'Jean-Michel', 19640127),
('Kandinsky', 'Vassily', 18661204);




#------------------------------------------------------------
# Table: Technique
#------------------------------------------------------------

CREATE TABLE Technique(
    idTechnique  INT  AUTO_INCREMENT  NOT NULL,
    nomTechnique VARCHAR (30) NOT NULL,
    CONSTRAINT Technique_PK PRIMARY KEY (idTechnique)
)ENGINE=InnoDB;

INSERT INTO Technique (nomTechnique) VALUES
('Huile sur toile'),
('Dessin à la plume'),
('Mine de plomb'),
('Encre brune'),
('Eau forte'),
('Sculpture classique'),
('Gravure'),
('Sculpture moderne'),
('Photographie'),
('Acrylique');

#------------------------------------------------------------
# Table: Film
#------------------------------------------------------------

CREATE TABLE Oeuvre(
    idOeuvre      INT  AUTO_INCREMENT  NOT NULL,
    titre         VARCHAR (100) NOT NULL,
    anneeCreation    SMALLINT (10),
    artisteId INT NOT NULL,
    techniqueId       INT NOT NULL,
    disponible       BOOLEAN DEFAULT true,
    CONSTRAINT Oeuvre_PK PRIMARY KEY (idOeuvre),
    CONSTRAINT Oeuvre_Artiste_FK FOREIGN KEY (artisteId) REFERENCES Artiste(idArtiste),
    CONSTRAINT Oeuvre_Technique_FK FOREIGN KEY (techniqueId) REFERENCES Technique(idTechnique)
)ENGINE=InnoDB;






#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
    idUtilisateur INT  AUTO_INCREMENT  NOT NULL,
    nom           VARCHAR (100) NOT NULL,
    prenom        VARCHAR (100) NOT NULL,
    dateNaissance DATE NOT NULL,
    email          VARCHAR (100) NOT NULL,
    motDePasse    VARCHAR (100) NOT NULL,
    CONSTRAINT Utilisateur_PK PRIMARY KEY (idUtilisateur)
)ENGINE=InnoDB;

INSERT INTO Utilisateur (nom, prenom, dateNaissance, email, motDePasse) VALUES
    ('admin', 'admin',19921206,'admin@artrental.com', 'azerty');

#------------------------------------------------------------
# Table: Emprunt
#------------------------------------------------------------

CREATE TABLE Emprunt(
	utilisateurId   INT NOT NULL,
	oeuvreId   		INT NOT NULL,
	dateEmprunt 	DATETIME NOT NULL,
	dateRetour  	DATETIME,
	CONSTRAINT Emprunt_PK PRIMARY KEY (utilisateurId,oeuvreId, dateEmprunt),
	CONSTRAINT Emprunt_Utilisateur_FK FOREIGN KEY (utilisateurId) REFERENCES Utilisateur(idUtilisateur),
	CONSTRAINT Emprunt_Oeuvre_FK FOREIGN KEY (oeuvreId) REFERENCES Oeuvre(idOeuvre)
)ENGINE=InnoDB;

INSERT INTO Oeuvre (titre, anneeCreation, artisteId, techniqueId) VALUES
    ('L\'homme à la pipe',1889, 1, 5),
    ('Guernica', 1937, 6, 1),
    ('Ma destinée', 1857, 4, 2),
    ('La joconde', 1506, 2, 1),
    ('La nuit étoilée', 1889,1, 1),
    ('La gare saint-lazare', 1877, 7, 1),
    ('La persistance de la mémoire', 1931, 5, 1),
    ('Les sabines', 1799, 8, 1),
    ('La promenade', 1875, 7, 1),
    ('La ronde de nuit', 1642, 3, 1),
    ('La liberté guidant le peuple', 1830, 9, 1 ),
    ('Les demoiselles D\'avignon', 1907, 6, 1 ),
    ('Environs de Gravesend', 1885,10, 5 ),
    ('Meduse',1638, 12, 6),
    ('Sirène',1900, 13, 6),
    ('Forever bicycles', 2011, 14, 8),
    ('Segment bleu', 1921,16,1),
    ('La jeune fille devant un miroir', 1932, 6, 1);
