INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `color`, `password`) VALUES
(1, 'Alice', 'Smith',    'alice@example.com', 'Azure',     'password'),
(2, 'Bob',   'Johnson',  'bob@example.com',   'Burgundy',  '123'),
(3, 'Carol', 'Williams', 'carol@example.com', 'Cerulean',  'password'),
(4, 'Dan',   'Brown',    'dan@example.com',   'Dandelion', '123'),
(5, 'Erin',  'Jones',    'erin@example.com',  'Ecru',      'password'),
(6, 'Frank', 'Miller',   'frank@example.com', 'Fuchsia',   '123');

INSERT INTO `ping-pong` (`id`, `price`) VALUES
(1, 5);

INSERT INTO `seats` (`id`, `type`, `price`) VALUES
(1, 'Middle',  5),
(2, 'Aisle',  10),
(3, 'Window', 15);

INSERT INTO `offices` (`id`, `type`, `price`) VALUES
(1, 'Cramped lil\' office', 25),
(2, 'L-shaped office',      30),
(3, 'T-shaped office',      35);

INSERT INTO `slots` (`id`, `service`, `service_id`, `time`, `quantity`) VALUES
( 1, 'ping-pong', 1, '2015-08-08 17:00:00',  3),
( 2, 'ping-pong', 1, '2015-08-08 19:00:00',  4),
( 3, 'ping-pong', 1, '2015-08-08 22:00:00', 20),
( 4, 'ping-pong', 1, '2015-08-09 12:00:00',  5),
( 5, 'ping-pong', 1, '2015-08-09 16:30:00', 10),
( 6, 'ping-pong', 1, '2015-08-09 18:00:00', 15),
( 7, 'seat',      1, '2015-08-08 13:30:00', 15),
( 8, 'seat',      2, '2015-08-08 13:30:00', 10),
( 9, 'seat',      3, '2015-08-08 13:30:00', 10),
(10, 'seat',      1, '2015-08-08 16:00:00', 15),
(11, 'seat',      2, '2015-08-08 16:00:00', 10),
(12, 'seat',      3, '2015-08-08 16:00:00', 10),
(13, 'seat',      1, '2015-08-09 10:00:00', 15),
(14, 'seat',      2, '2015-08-09 10:00:00', 10),
(15, 'seat',      3, '2015-08-09 10:00:00',  5),
(16, 'office',    1, '2015-08-08 08:00:00',  2),
(17, 'office',    2, '2015-08-08 08:00:00',  2),
(18, 'office',    3, '2015-08-08 08:00:00',  2),
(19, 'office',    1, '2015-08-08 14:00:00',  2),
(20, 'office',    2, '2015-08-08 14:00:00',  2),
(21, 'office',    3, '2015-08-08 14:00:00',  2),
(22, 'office',    1, '2015-08-09 12:00:00',  3),
(23, 'office',    2, '2015-08-09 12:00:00',  2),
(24, 'office',    3, '2015-08-09 12:00:00',  1);

INSERT INTO `purchases` (`id`, `user_id`, `slot_id`) VALUES
( 1, 1,  1),
( 2, 2,  1),
( 3, 3,  1),
( 4, 1,  4),
( 5, 2,  4),
( 6, 2,  8),
( 7, 3,  8),
( 8, 4,  8),
( 9, 3, 14),
(10, 4, 14),
(11, 2, 16),
(12, 3, 16);
