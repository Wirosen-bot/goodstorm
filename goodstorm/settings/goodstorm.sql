CREATE TABLE `good` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `about` mediumtext,
  `cost` float NOT NULL DEFAULT '0',
  `img` varchar(255) NOT NULL
);

CREATE TABLE `good_sklad` (
  `sklad_id` int NOT NULL,
  `good_id` int NOT NULL,
  `colvo` int NOT NULL DEFAULT '1'
);

CREATE TABLE `sklad` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `about` text
);

CREATE TABLE `sold` (
  `id` int NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `sold_good` (
  `id` int NOT NULL,
  `cost` int NOT NULL,
  `good_id` int NOT NULL,
  `colvo` int NOT NULL DEFAULT '1',
  `sold_id` int NOT NULL
);

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int NOT NULL DEFAULT '0'
);

ALTER TABLE `good`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `good_sklad`
  ADD KEY `sklad_id` (`sklad_id`),
  ADD KEY `good_id` (`good_id`);

ALTER TABLE `sklad`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sold`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sold_good`
  ADD PRIMARY KEY (`id`),
  ADD KEY `good_id` (`good_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `good`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `sklad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `sold`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `sold_good`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;
