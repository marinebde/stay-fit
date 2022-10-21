/* Création de la base de données */

CREATE DATABASE IF NOT EXISTS ecf2022 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

/* Création des différentes Tables */

CREATE TABLE module 
(
    id INT AUTO_INCREMENT NOT NULL, 
    nom VARCHAR(250) NOT NULL, 
    statut TINYINT(1) NOT NULL, 
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

/* Insertion des données Modules */
INSERT INTO module (id, nom, statut) 
VALUES
(1, 'PAIEMENT 3X', 1),
(2, 'VENTE BOISSONS', 1),
(3, 'COURS COLLECTIFS', 1);

CREATE TABLE partenaire 
(
   id INT AUTO_INCREMENT NOT NULL,
   nom VARCHAR(80) NOT NULL,
   statut TINYINT(1) NOT NULL,
   PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

/* Insertion des données Partenaires */
INSERT INTO partenaire (id, nom, statut) 
VALUES
(298, 'Basic Fit Ouest', 1),
(299, 'Sport2000', 1),
(302, 'Basic Fit Nord', 1),
(303, 'Basic Fit IDF', 1);

CREATE TABLE partenaire_module 
(
  partenaire_id INT NOT NULL,
  module_id INT NOT NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

/* Insertion des données Partenaire/Module */
INSERT INTO partenaire_module (partenaire_id, module_id) 
VALUES
(298, 1),
(298, 3),
(299, 2),
(299, 3),
(302, 1),
(302, 2),
(303, 2);


CREATE TABLE structure (
  id INT AUTO_INCREMENT NOT NULL,
  nom VARCHAR(80) NOT NULL,
  adresse VARCHAR(360) NOT NULL,
  code_postal INT NOT NULL,
  ville VARCHAR(80) NOT NULL,
  statut TINYINT(1) NOT NULL,
  nom_gerant VARCHAR(80) NOT NULL,
  partenaire_id INT DEFAULT NULL,
  FOREIGN KEY (partenaire_id) REFERENCES partenaire (id),
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

/* Insertion des données Structures */
INSERT INTO structure (id, nom, adresse, code_postal, ville, statut, nom_gerant, partenaire_id) 
VALUES
(74, 'Basic Fit Ouest - Saint Nazaire', '37 Allée des pingouins', 44600, 'Saint Nazaire', 0, 'Boidé Marine', 298),
(75, 'Basic Fit Ouest - Trignac', '5 Allée Albert Camus', 44570, 'Trignac', 0, 'Boidé Marine', 298),
(76, 'Sport 2000 -  Saint Nazaire', '37 Allée des pingouins', 44600, 'Saint Nazaire', 1, 'Boidé Marine', 299),
(77, 'Sport 2000 -  Trignac', '5 Allée Albert Camus', 44570, 'Trignac', 1, 'Boidé Marine', 299),
(80, 'new', 'totot', 55, 'Saint Nazaire', 1, 'Boidé Marine', 298);

CREATE TABLE structure_modules 
(
  id INT AUTO_INCREMENT NOT NULL,
  is_active TINYINT(1) NOT NULL,
  structure_id INT DEFAULT NULL,
  module_id INT DEFAULT NULL,
  PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

/* Insertion des données Structure/Module */
INSERT INTO structure_modules (id, is_active, structure_id, module_id) 
VALUES
(214, 1, 76, 2),
(215, 1, 76, 3),
(216, 1, 77, 2),
(217, 1, 77, 3),
(232, 1, 74, 3),
(233, 1, 75, 3),
(246, 1, 74, 1),
(247, 1, 75, 1),
(252, 1, 80, 1),
(253, 1, 80, 3);

CREATE TABLE user 
(
    id INT AUTO_INCREMENT NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(180) NOT NULL,
    roles JSON NOT NULL, 
    password VARCHAR(255) NOT NULL, 
    statut TINYINT(1) NOT NULL, 
    date_connexion DATE DEFAULT NULL,
    token VARCHAR(255) DEFAULT NULL, 
    partenaires_id INT DEFAULT NULL,
    FOREIGN KEY (partenaires_id) REFERENCES partenaire (id),
    structures_id INT DEFAULT NULL,
    FOREIGN KEY (structures_id) REFERENCES structure (id),
    UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

/* Insertion des données Utilisateurs */
INSERT INTO user (id, nom, prenom, email, password, statut, roles, date_connexion, structures_id, partenaires_id, token) 
VALUES
(36, 'boidé', 'marine', 'mbcontactservice@gmail.com', '$2y$13$x0cbJ0iEAElxqUMbQ7XZe.lRMfxAopZQVG9meTmhqrhrrj2XDdn9O', 1, '[\"ROLE_ADMIN\"]', '2022-10-19 12:45:01', NULL, 298, NULL);


/*Test des actions CRUD */

SELECT * FROM user;

UPDATE user
SET statut = '0'
WHERE id = 1;

DELETE FROM user 
WHERE id = 1;


/* Attribution des privilèges administrateurs */

CREATE USER IF NOT EXISTS 'MAELANN'@'%' IDENTIFIED BY '$2y$10$t62k6NPn4AcdCpFFqJ4/qeQBO9W.lrZqzvgmFu7IlzHavZwEiv7pS';

GRANT ALL PRIVILEGES 
ON `ecf2022`.*
TO 'MAELANN'@'%';

CREATE USER IF NOT EXISTS 'MAELLA'@'%' IDENTIFIED BY '$2y$10$74v5MPWHDdgZdOHtnp7FjO1vsAE.e6yT6OlCmuiXBROkJBRUcM5Oq';

GRANT ALL PRIVILEGES 
ON `ecf2022`.*
TO 'MAELLA'@'%';

CREATE USER IF NOT EXISTS 'GERALD'@'%' IDENTIFIED BY '$2y$10$zPOy/DRhlLUcvwqqD8/wNuaBSQ0RYemzu2uIjn7JApCDw45iLrPfq';

GRANT ALL PRIVILEGES 
ON `ecf2022`.*
TO 'GERALD'@'%';

/* Sauvegarde de la base de données */

mysqldump  --user=mon_user --password=mon_password_encrypté --single-transaction --skip-lock-tables --databases ecf2022  > bdd.sql

/* Restauration de la base de données */

mysql --user=mon_user --password=mon_password_encrypté ecf2022 < bdd.sql