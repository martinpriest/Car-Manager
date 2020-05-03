INSERT IGNORE INTO 'user' (login, password, email)
VALUES
-- account with data
("user1", "aaaaa", "user1@mail.pl"),
-- account without data trying to access other user data
("user2", "aaaaa", "user2@mail.pl"),
-- trying make two account with same login
("sameLogin", "aaaaa", "mail1@test.pl"),
("sameLogin", "aaaaa", "mail2@test.pl"),
-- trying make two account with same mail
("otherLogin1", "aaaaa", "sameMail@test.pl"),
("otherLogin2", "aaaaa", "sameMail@test.pl"),
-- trying make two account with same login and mail
("sameLogin", "aaaaa", "sameMail@test.pl"),
-- trying make account without password
("userWithoutPassword", "", "userWithoutPassword@test.pl"),
-- trying make account without login
("", "aaaaa", "userWithoutLogin@test.pl"),
-- trying make account without mail
("userWithoutMail", "aaaaa", ""),
-- trying make account with too short password
("userWithoutMail", "aaa", ""),