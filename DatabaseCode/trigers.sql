DROP TRIGGER IF EXISTS mydb.ocena_insert;

CREATE TRIGGER mydb.ocena_insert AFTER INSERT ON mydb.Ocena
FOR EACH ROW
UPDATE mydb.Tutor
SET mydb.Tutor.ukupnaOcena = (SELECT AVG(Ocena.ocena) FROM Ocena WHERE Tutor.idTutor=Ocena.idTutor)
WHERE mydb.Tutor.idTutor = NEW.idTutor;

DROP TRIGGER IF EXISTS mydb.ocena_delete;

CREATE TRIGGER mydb.ocena_delete AFTER DELETE ON mydb.Ocena
FOR EACH ROW
UPDATE mydb.Tutor
SET mydb.Tutor.ukupnaOcena = (SELECT AVG(Ocena.ocena) FROM Ocena WHERE Tutor.idTutor=Ocena.idTutor)
WHERE mydb.Tutor.idTutor = OLD.idTutor;

DROP TRIGGER IF EXISTS mydb.ocena_update;

CREATE TRIGGER mydb.ocena_update AFTER UPDATE ON mydb.Ocena
FOR EACH ROW
UPDATE mydb.Tutor
SET mydb.Tutor.ukupnaOcena = (SELECT AVG(Ocena.ocena) FROM Ocena WHERE Tutor.idTutor=Ocena.idTutor)
WHERE mydb.Tutor.idTutor = NEW.idTutor;
