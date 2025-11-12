USE covoiturage;

-- Agencies
INSERT INTO agencies (name, city) VALUES ('Paris','Paris');
INSERT INTO agencies (name, city) VALUES ('Lyon','Lyon');
INSERT INTO agencies (name, city) VALUES ('Marseille','Marseille');
INSERT INTO agencies (name, city) VALUES ('Toulouse','Toulouse');
INSERT INTO agencies (name, city) VALUES ('Nice','Nice');
INSERT INTO agencies (name, city) VALUES ('Nantes','Nantes');
INSERT INTO agencies (name, city) VALUES ('Strasbourg','Strasbourg');
INSERT INTO agencies (name, city) VALUES ('Montpellier','Montpellier');
INSERT INTO agencies (name, city) VALUES ('Bordeaux','Bordeaux');
INSERT INTO agencies (name, city) VALUES ('Lille','Lille');
INSERT INTO agencies (name, city) VALUES ('Rennes','Rennes');
INSERT INTO agencies (name, city) VALUES ('Reims','Reims');

-- Admin account
INSERT INTO users (nom, prenom, email, phone, role, password_hash) VALUES ('Admin', 'Principal', 'admin@entreprise.com', '0600000000', 'admin', '');

-- Users
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Alexandre','Martin','alexandre.martin@email.fr','0612345678','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Sophie','Dubois','sophie.dubois@email.fr','0698765432','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Julien','Bernard','julien.bernard@email.fr','0622446688','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Camille','Moreau','camille.moreau@email.fr','0611223344','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Lucie','Lefèvre','lucie.lefevre@email.fr','0777889900','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Thomas','Leroy','thomas.leroy@email.fr','0655443322','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Chloé','Roux','chloe.roux@email.fr','0633221199','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Maxime','Petit','maxime.petit@email.fr','0766778899','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Laura','Garnier','laura.garnier@email.fr','0688776655','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Antoine','Dupuis','antoine.dupuis@email.fr','0744556677','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Emma','Lefebvre','emma.lefebvre@email.fr','0699887766','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Louis','Fontaine','louis.fontaine@email.fr','0655667788','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Clara','Chevalier','clara.chevalier@email.fr','0788990011','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Nicolas','Robin','nicolas.robin@email.fr','0644332211','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Marine','Gauthier','marine.gauthier@email.fr','0677889922','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Pierre','Fournier','pierre.fournier@email.fr','0722334455','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Sarah','Girard','sarah.girard@email.fr','0688665544','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Hugo','Lambert','hugo.lambert@email.fr','0611223366','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Julie','Masson','julie.masson@email.fr','0733445566','user');
INSERT INTO users (nom, prenom, email, phone, role) VALUES ('Arthur','Henry','arthur.henry@email.fr','0666554433','user');

-- Trips (from artisanentreprise.xlsx) --
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Paris' LIMIT 1), (SELECT id FROM agencies WHERE name='Lyon' LIMIT 1), '2025-12-01 08:00:00', '2025-12-01 10:00:00', 4, 4, (SELECT id FROM users WHERE email='alexandre.martin@email.fr' LIMIT 1), (SELECT id FROM users WHERE email='alexandre.martin@email.fr' LIMIT 1));

-- Generated trips from agences.txt pairing rule
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Paris' LIMIT 1),
        (SELECT id FROM agencies WHERE name='Strasbourg' LIMIT 1),
        '2025-11-15 09:00:00',
        '2025-11-15 15:30:00',
        4, 3,
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 0),
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 0)
);
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Lyon' LIMIT 1),
        (SELECT id FROM agencies WHERE name='Montpellier' LIMIT 1),
        '2025-11-16 07:00:00',
        '2025-11-16 13:15:00',
        4, 3,
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 1),
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 1)
);
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Marseille' LIMIT 1),
        (SELECT id FROM agencies WHERE name='Bordeaux' LIMIT 1),
        '2025-11-17 09:00:00',
        '2025-11-17 13:15:00',
        4, 3,
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 2),
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 2)
);
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Toulouse' LIMIT 1),
        (SELECT id FROM agencies WHERE name='Lille' LIMIT 1),
        '2025-11-18 10:00:00',
        '2025-11-18 14:45:00',
        4, 3,
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 3),
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 3)
);
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Nice' LIMIT 1),
        (SELECT id FROM agencies WHERE name='Rennes' LIMIT 1),
        '2025-11-19 08:15:00',
        '2025-11-19 11:45:00',
        4, 3,
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 4),
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 4)
);
INSERT INTO trips (agency_from_id, agency_to_id, departure_datetime, arrival_datetime, seats_total, seats_available, contact_user_id, created_by_user_id)
VALUES ((SELECT id FROM agencies WHERE name='Nantes' LIMIT 1),
        (SELECT id FROM agencies WHERE name='Reims' LIMIT 1),
        '2025-11-20 09:30:00',
        '2025-11-20 13:15:00',
        4, 3,
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 5),
        (SELECT id FROM users ORDER BY id LIMIT 1 OFFSET 5)
);
