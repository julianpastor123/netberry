--
-- Database: `netberry`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `IDCATEGORIA` int(11) NOT NULL,
  `NOMBRE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`IDCATEGORIA`, `NOMBRE`) VALUES
(1, 'PHP'),
(2, 'Javascript'),
(3, 'JQuery'),
(4, 'CSS');

-- --------------------------------------------------------

--
-- Table structure for table `tarea`
--

CREATE TABLE `tarea` (
  `IDTAREA` int(11) NOT NULL,
  `IDCATEGORIA` varchar(20) NOT NULL,
  `NOMBRE` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tarea`
--

INSERT INTO `tarea` (`IDTAREA`, `IDCATEGORIA`, `NOMBRE`) VALUES
(1, '2,3', 'Programar abm'),
(3, '4', 'PRUEBA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IDCATEGORIA`);

--
-- Indexes for table `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`IDTAREA`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IDCATEGORIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tarea`
--
ALTER TABLE `tarea`
  MODIFY `IDTAREA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
