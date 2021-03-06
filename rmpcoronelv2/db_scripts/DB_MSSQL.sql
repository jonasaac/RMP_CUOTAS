USE [master]
GO
/****** Object:  Database [RMPCORONELv2]    Script Date: 29/04/2016 16:45:58 ******/
CREATE DATABASE [RMPCORONELv2]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'RMPCORONELv2c', FILENAME = N'C:\Program Files (x86)\Microsoft SQL Server\MSSQL12.MSSQLSERVER\MSSQL\DATA\RMPCORONELv2.mdf' , SIZE = 37888KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'RMPCORONELv2c_log', FILENAME = N'C:\Program Files (x86)\Microsoft SQL Server\MSSQL12.MSSQLSERVER\MSSQL\DATA\RMPCORONELv2_log.ldf' , SIZE = 353216KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [RMPCORONELv2] SET COMPATIBILITY_LEVEL = 100
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [RMPCORONELv2].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [RMPCORONELv2] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET ARITHABORT OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [RMPCORONELv2] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [RMPCORONELv2] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET  DISABLE_BROKER 
GO
ALTER DATABASE [RMPCORONELv2] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [RMPCORONELv2] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET RECOVERY FULL 
GO
ALTER DATABASE [RMPCORONELv2] SET  MULTI_USER 
GO
ALTER DATABASE [RMPCORONELv2] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [RMPCORONELv2] SET DB_CHAINING OFF 
GO
ALTER DATABASE [RMPCORONELv2] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [RMPCORONELv2] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [RMPCORONELv2] SET DELAYED_DURABILITY = DISABLED 
GO
USE [RMPCORONELv2]
GO
/****** Object:  User [CAMANCHACA_STGO\tcandia]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\tcandia] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\supervisorcalidad]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\supervisorcalidad] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\rpuentes]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\rpuentes] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\romanathno]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\romanathno] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\rmacias]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\rmacias] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\rcartes]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\rcartes] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\rcarrillo]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\rcarrillo] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\rarenas]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\rarenas] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\pvigueras]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\pvigueras] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\priquelme]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\priquelme] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\pherrerau]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\pherrerau] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\npizarro]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\npizarro] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\mficasanmarino]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\mficasanmarino] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\lseguel]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\lseguel] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\lmartinez]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\lmartinez] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\lmardonesf]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\lmardonesf] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\labo-tamarugal]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\labo-tamarugal] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\jturnoconserva]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\jturnoconserva] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\jolivares]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\jolivares] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\jgatica]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\jgatica] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\jfinschi]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\jfinschi] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\jcorvalan]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\jcorvalan] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\imontecino]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\imontecino] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\gfernandez]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\gfernandez] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\galarconb]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\galarconb] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\fsepulvedan]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\fsepulvedan] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\erios]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\erios] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\despinoza]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\despinoza] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\descargavaldivia]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\descargavaldivia] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\cpuga]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\cpuga] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\cpconserva]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\cpconserva] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\cmuñoz]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\cmuñoz] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\AseguramientoCalidad]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\AseguramientoCalidad] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\arubilar]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\arubilar] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\analista]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\analista] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\agonzalez]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\agonzalez] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [CAMANCHACA_STGO\afloras]    Script Date: 29/04/2016 16:45:59 ******/
CREATE USER [CAMANCHACA_STGO\afloras] WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\tcandia]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\supervisorcalidad]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\rpuentes]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\romanathno]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\rmacias]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\rcartes]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\rcarrillo]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\rarenas]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\pvigueras]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\priquelme]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\pherrerau]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\npizarro]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\mficasanmarino]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\lseguel]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\lmartinez]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\lmardonesf]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\labo-tamarugal]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\jturnoconserva]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\jolivares]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\jgatica]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\jfinschi]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\jcorvalan]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\imontecino]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\gfernandez]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\galarconb]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\fsepulvedan]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\erios]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\despinoza]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\descargavaldivia]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\cpuga]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\cpconserva]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\cmuñoz]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\AseguramientoCalidad]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\arubilar]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\analista]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\agonzalez]
GO
ALTER ROLE [db_datareader] ADD MEMBER [CAMANCHACA_STGO\afloras]
GO
/****** Object:  UserDefinedFunction [dbo].[ConvertirFecha]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE FUNCTION [dbo].[ConvertirFecha]( @date DATETIME )
RETURNS VARCHAR(50)
BEGIN
	RETURN (SELECT CAST(DATEPART(dd, @date) AS VARCHAR) +
	'-' +
	SUBSTRING('Ene Feb Mar Abr May Jun Jul Ago Sep Oct Nov Dic ', (DATEPART(m, @date) * 4) - 3, 3) +
	'-' +
	CAST(DATEPART(YYYY, @date) AS VARCHAR) +
	' ' +
	CAST(DATEPART(hh, @date) AS VARCHAR) +
	':' +
	CAST(DATEPART(mi, @date) AS VARCHAR))
END;

GO
/****** Object:  Table [dbo].[areas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[areas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](20) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[areas_auxiliares]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[areas_auxiliares](
	[area_id] [int] NOT NULL,
	[auxiliar_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[area_id] ASC,
	[auxiliar_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[areas_camiones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[areas_camiones](
	[area_id] [int] NOT NULL,
	[camion_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[area_id] ASC,
	[camion_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[areas_grupos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[areas_grupos](
	[area_id] [int] NOT NULL,
	[grupo_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[area_id] ASC,
	[grupo_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[areas_naves]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[areas_naves](
	[area_id] [int] NOT NULL,
	[nave_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[area_id] ASC,
	[nave_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[areas_recintos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[areas_recintos](
	[area_id] [int] NOT NULL,
	[recinto_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[area_id] ASC,
	[recinto_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[areas_recursos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[areas_recursos](
	[area_id] [int] NOT NULL,
	[recurso_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[area_id] ASC,
	[recurso_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[arte_pesca]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[arte_pesca](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](20) NOT NULL,
	[recurso_id] [int] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[auxiliares]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[auxiliares](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tipo_entidad] [smallint] NOT NULL,
	[division_id] [int] NOT NULL,
	[rut] [varchar](8) NOT NULL,
	[verificador] [char](1) NOT NULL,
	[nombre_razon_social] [varchar](50) NULL,
	[nombre] [varchar](30) NULL,
	[apellido_paterno] [varchar](30) NULL,
	[apellido_materno] [varchar](30) NULL,
	[domicilio] [varchar](200) NOT NULL,
	[ciudad_id] [int] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
	[chofer] [bit] NOT NULL,
	[armador] [bit] NOT NULL,
	[encargado_planta] [bit] NOT NULL,
	[capitan] [bit] NOT NULL,
	[destinatario] [bit] NOT NULL,
	[representante] [bit] NOT NULL,
	[transporte] [bit] NOT NULL,
	[tcs] [bit] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[bodegas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[bodegas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nave_id] [int] NOT NULL,
	[nro] [int] NOT NULL,
	[capacidad] [decimal](10, 3) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[calibres]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[calibres](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](20) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[camiones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[camiones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[patente] [varchar](8) NOT NULL,
	[transporte_id] [int] NOT NULL,
	[tipo_camion] [varchar](40) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ciudades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ciudades](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[controles_calidad]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[controles_calidad](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[guia_encabezado_id] [int] NOT NULL,
	[tratamiento_id] [int] NULL,
	[tvn] [varchar](7) NULL,
	[agua] [varchar](7) NULL,
	[ph] [varchar](7) NULL,
	[c] [varchar](7) NULL,
	[n_litro] [varchar](7) NULL,
	[talla] [varchar](7) NULL,
	[peso] [varchar](7) NULL,
	[moda] [varchar](7) NULL,
	[cms] [varchar](7) NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NULL,
	[actualizado] [datetime] NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[descarga_detalles]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[descarga_detalles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[descarga_encabezado_id] [int] NOT NULL,
	[especie_id] [int] NOT NULL,
	[zona_pesca] [int] NOT NULL,
	[destinatario_id] [int] NULL,
	[tcs_id] [int] NULL,
	[resolucion] [varchar](15) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[descarga_detalles_unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[descarga_detalles_unidades](
	[descarga_detalle_id] [int] NOT NULL,
	[unidad_id] [int] NOT NULL,
	[cantidad] [decimal](10, 6) NULL,
PRIMARY KEY CLUSTERED 
(
	[descarga_detalle_id] ASC,
	[unidad_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[descarga_encabezados]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[descarga_encabezados](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[codigo_descarga] [varchar](10) NOT NULL,
	[tipo_descarga_id] [int] NOT NULL,
	[movimiento_id] [int] NOT NULL,
	[fecha_pesca] [datetime] NULL,
	[inicio_desembarque] [datetime] NOT NULL,
	[termino_desembarque] [datetime] NOT NULL,
	[recalada_id] [int] NOT NULL,
	[sin_pesca] [bit] NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NOT NULL,
	[actualizado] [datetime] NOT NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NULL,
	[latitud] [varchar](50) NULL,
	[longitud] [varchar](50) NULL,
	[fecha_primer_lance] [datetime] NULL,
	[zona_primer_lance] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[divisiones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[divisiones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[especies]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[especies](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[ltp] [bit] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[especies_recursos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[especies_recursos](
	[especie_id] [int] NOT NULL,
	[recurso_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[especie_id] ASC,
	[recurso_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[estados]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[estados](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](20) NOT NULL,
	[paridad] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[folio_detalles]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[folio_detalles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[folio_encabezado_id] [int] NOT NULL,
	[descarga_detalle_id] [int] NOT NULL,
	[secuencial] [int] NOT NULL,
	[especie_id] [int] NOT NULL,
	[fecha_produccion] [date] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[folio_detalles_lote_encabezados]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[folio_detalles_lote_encabezados](
	[folio_detalle_id] [int] NOT NULL,
	[lote_encabezado_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[folio_detalle_id] ASC,
	[lote_encabezado_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[folio_detalles_unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[folio_detalles_unidades](
	[folio_detalle_id] [int] NOT NULL,
	[unidad_id] [int] NOT NULL,
	[cantidad] [decimal](10, 6) NULL,
PRIMARY KEY CLUSTERED 
(
	[folio_detalle_id] ASC,
	[unidad_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[folio_encabezados]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[folio_encabezados](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[recurso_id] [int] NOT NULL,
	[division_id] [int] NOT NULL,
	[nro_folio] [varchar](6) NOT NULL,
	[calibre] [int] NOT NULL,
	[fecha_recepcion] [date] NOT NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NOT NULL,
	[actualizado] [datetime] NOT NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NOT NULL,
	[latitud] [varchar](50) NULL,
	[longitud] [varchar](50) NULL,
	[fecha_primer_lance] [datetime] NULL,
	[zona_primer_lance] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[grupos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[grupos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[division_id] [int] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[grupos_privilegios]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[grupos_privilegios](
	[grupo_id] [int] NOT NULL,
	[privilegio_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[grupo_id] ASC,
	[privilegio_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[grupos_usuarios]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[grupos_usuarios](
	[grupo_id] [int] NOT NULL,
	[usuario_uid] [varchar](40) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[grupo_id] ASC,
	[usuario_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[guia_detalles]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[guia_detalles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[guia_encabezado_id] [int] NOT NULL,
	[descarga_detalle_id] [int] NOT NULL,
	[especie_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[guia_detalles_unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[guia_detalles_unidades](
	[guia_detalle_id] [int] NOT NULL,
	[unidad_id] [int] NOT NULL,
	[cantidad] [decimal](10, 6) NULL,
PRIMARY KEY CLUSTERED 
(
	[guia_detalle_id] ASC,
	[unidad_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[guia_encabezados]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[guia_encabezados](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[recurso_id] [int] NOT NULL,
	[division_id] [int] NOT NULL,
	[virtual] [bit] NULL,
	[nro_guia] [varchar](50) NULL,
	[movimiento_id] [int] NOT NULL,
	[origen_id] [int] NOT NULL,
	[destino_id] [int] NOT NULL,
	[camion_id] [int] NULL,
	[chofer_id] [int] NULL,
	[fecha_salida] [datetime] NOT NULL,
	[fecha_recepcion] [datetime] NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NOT NULL,
	[actualizado] [datetime] NOT NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lote_detalles]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lote_detalles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[lote_encabezado_id] [int] NOT NULL,
	[pallet] [varchar](30) NULL,
	[calibre_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[lote_detalles_unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[lote_detalles_unidades](
	[lote_detalle_id] [int] NOT NULL,
	[unidad_id] [int] NOT NULL,
	[cantidad] [numeric](10, 3) NULL,
PRIMARY KEY CLUSTERED 
(
	[lote_detalle_id] ASC,
	[unidad_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[lote_encabezados]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[lote_encabezados](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[recurso_id] [int] NOT NULL,
	[division_id] [int] NOT NULL,
	[lote] [varchar](15) NOT NULL,
	[sub_codigo] [char](1) NOT NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NOT NULL,
	[actualizado] [datetime] NOT NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mareas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mareas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[division_id] [int] NOT NULL,
	[recurso_id] [int] NOT NULL,
	[nave_id] [int] NOT NULL,
	[arte_pesca_id] [int] NOT NULL,
	[capitan_id] [int] NOT NULL,
	[puerto_id] [int] NOT NULL,
	[fecha_zarpe] [datetime] NOT NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL,
	[creado] [datetime] NULL,
	[actualizado] [datetime] NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mareas1]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mareas1](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[division_id] [int] NOT NULL,
	[recurso_id] [int] NOT NULL,
	[nave_id] [int] NOT NULL,
	[arte_pesca_id] [int] NOT NULL,
	[capitan_id] [int] NOT NULL,
	[puerto_id] [int] NOT NULL,
	[fecha_zarpe] [datetime] NOT NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NULL,
	[actualizado] [datetime] NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[movimientos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[movimientos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](20) NOT NULL,
	[tipo] [smallint] NOT NULL,
	[estado_id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[naves]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[naves](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[division_id] [int] NOT NULL,
	[matricula] [varchar](20) NOT NULL,
	[regimen_id] [int] NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[zona_operacion_id] [int] NULL,
	[registro_pesca] [varchar](6) NULL,
	[senal_distintiva] [varchar](10) NULL,
	[armador_id] [int] NULL,
	[representante_id] [int] NULL,
	[capitan_id] [int] NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[naves_recursos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[naves_recursos](
	[nave_id] [int] NOT NULL,
	[recurso_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[nave_id] ASC,
	[recurso_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[naves_unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[naves_unidades](
	[nave_id] [int] NOT NULL,
	[unidad_id] [int] NOT NULL,
	[capacidad] [decimal](10, 6) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[nave_id] ASC,
	[unidad_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[plantas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[plantas](
	[id] [int] NOT NULL,
	[codigo] [int] NOT NULL,
	[seccion] [char](1) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[pontones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[pontones](
	[id] [int] NOT NULL,
	[puerto_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[privilegios]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[privilegios](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](50) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[puertos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[puertos](
	[id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[recaladas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[recaladas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[marea_id] [int] NOT NULL,
	[fecha_recalada] [datetime] NOT NULL,
	[ponton_id] [int] NOT NULL,
	[observaciones] [text] NULL,
	[estado_id] [int] NULL DEFAULT ((3)),
	[creado] [datetime] NULL,
	[actualizado] [datetime] NULL,
	[cerrado] [datetime] NULL,
	[usuario_uid] [varchar](40) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[recintos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[recintos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[division_id] [int] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[recursos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[recursos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[unidad_principal_id] [int] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[recursos_unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[recursos_unidades](
	[recurso_id] [int] NOT NULL,
	[unidad_id] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[recurso_id] ASC,
	[unidad_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[regimenes]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[regimenes](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](30) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[tipo_descargas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[tipo_descargas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](30) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[tratamientos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[tratamientos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](30) NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[unidades]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[unidades](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](40) NOT NULL,
	[abreviacion] [varchar](6) NULL,
	[precision] [int] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[usuarios]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[usuarios](
	[uid] [varchar](40) NOT NULL,
	[nombre] [varchar](50) NOT NULL,
	[change_log] [bit] NOT NULL,
	[estado_id] [int] NULL DEFAULT ((1)),
	[creado] [datetime] NULL,
	[actualizado] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[zona_operaciones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[zona_operaciones](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[nombre] [varchar](30) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  View [dbo].[guias_sin_calidad]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[guias_sin_calidad]
AS
SELECT     id, nro_guia, movimiento_id, division_id, recurso_id, origen_id, destino_id, camion_id, chofer_id, fecha_salida, fecha_recepcion, observaciones, estado_id, creado, actualizado, cerrado, 
                      usuario_uid, virtual
FROM         dbo.guia_encabezados AS GuiaEncabezados
WHERE     (id NOT IN
                          (SELECT     guia_encabezado_id
                            FROM          dbo.controles_calidad AS ControlesCalidad)) AND (origen_id <> 28) AND (YEAR(fecha_recepcion) > 2015) AND (virtual <> 1)

GO
/****** Object:  View [dbo].[guias_con_calidad]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE VIEW [dbo].[guias_con_calidad]
AS
SELECT     id, nro_guia, movimiento_id, division_id, recurso_id, origen_id, destino_id, camion_id, chofer_id, fecha_salida, fecha_recepcion, observaciones, estado_id, creado,
                      actualizado, cerrado, usuario_uid, virtual
FROM         dbo.guia_encabezados AS GuiaEncabezados
WHERE     (id NOT IN
                          (SELECT     id
                            FROM          dbo.guias_sin_calidad))

GO
/****** Object:  View [dbo].[descargas_disponibles]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[descargas_disponibles]
AS
SELECT     *
FROM         descarga_encabezados DE
WHERE     DE.inicio_desembarque >= '01-01-2016' AND DE.id IN
                          ((SELECT DISTINCT id
                              FROM         (SELECT     DD.descarga_encabezado_id id, ROUND((DDU.cantidad - SUM(GDU.cantidad)), 4) disponible
                                                     FROM          descarga_detalles DD, descarga_detalles_unidades DDU, guia_detalles GD, guia_detalles_unidades GDU
                                                     WHERE      GD.descarga_detalle_id = DD.id AND DDU.unidad_id = GDU.unidad_id AND GDU.guia_detalle_id = GD.id AND DDU.descarga_detalle_id = DD.id
                                                     GROUP BY DD.descarga_encabezado_id, DD.id, DDU.cantidad) AS DDis
                              WHERE     DDis.disponible > 0)
                      UNION
                      (SELECT DISTINCT DD.descarga_encabezado_id id
                       FROM         descarga_detalles DD
                       WHERE     DD.id NOT IN
                                                  (SELECT     GD.descarga_detalle_id id
                                                    FROM          guia_detalles GD))
UNION
(SELECT DISTINCT DD.descarga_encabezado_id id
 FROM         descarga_detalles DD, guia_detalles GD, guia_encabezados GE
 WHERE     GE.estado_id = 3 AND GE.id = GD.guia_encabezado_id AND GD.descarga_detalle_id = DD.id))

GO
/****** Object:  View [dbo].[descargas_disponibles_folios]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[descargas_disponibles_folios]
AS
SELECT     DE.*
FROM         descarga_encabezados DE INNER JOIN
                      recaladas R ON R.id = DE.recalada_id INNER JOIN
                      mareas M ON M.id = R.marea_id
WHERE     DE.inicio_desembarque >= '01-01-2016' AND M.recurso_id = 2 AND DE.id IN
                          ((SELECT DISTINCT id
                              FROM         (SELECT     DD.descarga_encabezado_id id, Round((DDU.cantidad - Sum(FDU.cantidad)), 4) disponible
                                                     FROM          descarga_detalles DD INNER JOIN
                                                                            descarga_detalles_unidades DDU ON DD.id = DDU.descarga_detalle_id INNER JOIN
                                                                            folio_detalles FD ON DD.id = FD.descarga_detalle_id INNER JOIN
                                                                            folio_detalles_unidades FDU ON FD.id = FDU.folio_detalle_id
                                                     WHERE      DDU.unidad_id = FDU.unidad_id AND DD.destinatario_id = 95
                                                     GROUP BY DD.descarga_encabezado_id, DD.id, DDU.cantidad) AS DDis
                              WHERE     DDis.disponible > 0)
                      UNION
                      (SELECT DISTINCT DD.descarga_encabezado_id id
                       FROM         descarga_detalles DD
                       WHERE     DD.id NOT IN
                                                  (SELECT     FD.descarga_detalle_id id
                                                    FROM          folio_detalles FD) AND DD.destinatario_id = 95)
UNION
(SELECT DISTINCT DD.descarga_encabezado_id id
 FROM         descarga_detalles DD INNER JOIN
                        folio_detalles FD ON FD.descarga_detalle_id = DD.id INNER JOIN
                        folio_encabezados FE ON FE.id = FD.folio_encabezado_id
 WHERE     FE.estado_id = 3))

GO
/****** Object:  View [dbo].[v_armadores]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_armadores]
AS
SELECT     id, rut, verificador, nombre_razon_social, nombre, apellido_paterno, apellido_materno
FROM         dbo.auxiliares
WHERE     (armador = 1) OR
                      (representante = 1)

GO
/****** Object:  View [dbo].[v_camiones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_camiones]
AS
SELECT     dbo.camiones.id, dbo.camiones.patente, dbo.camiones.tipo_camion, dbo.auxiliares.nombre_razon_social
FROM         dbo.camiones INNER JOIN
                      dbo.auxiliares ON dbo.camiones.transporte_id = dbo.auxiliares.id AND dbo.auxiliares.transporte = 1

GO
/****** Object:  View [dbo].[v_choferes]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_choferes]
AS
SELECT     id, rut, nombre + ' ' + apellido_paterno + ' ' + apellido_materno AS nombre
FROM         dbo.auxiliares
WHERE     (chofer = 1)

GO
/****** Object:  View [dbo].[v_destinatarios]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_destinatarios]
AS
SELECT     nombre_razon_social, nombre, id
FROM         dbo.auxiliares
WHERE     (destinatario = 1)

GO
/****** Object:  View [dbo].[v_plantas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_plantas]
AS
SELECT     dbo.recintos.nombre, dbo.plantas.id
FROM         dbo.recintos INNER JOIN
                      dbo.plantas ON dbo.recintos.id = dbo.plantas.id

GO
/****** Object:  View [dbo].[v_pontones]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_pontones]
AS
SELECT     dbo.recintos.nombre, dbo.pontones.id
FROM         dbo.pontones INNER JOIN
                      dbo.recintos ON dbo.pontones.id = dbo.recintos.id

GO
/****** Object:  View [dbo].[v_puertos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_puertos]
AS
SELECT     dbo.recintos.id, dbo.recintos.nombre
FROM         dbo.puertos INNER JOIN
                      dbo.recintos ON dbo.puertos.id = dbo.recintos.id

GO
/****** Object:  View [dbo].[v_tcs]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_tcs]
AS
SELECT     nombre_razon_social, id
FROM         dbo.auxiliares
WHERE     (tcs = 1)

GO
ALTER TABLE [dbo].[areas]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[areas_auxiliares]  WITH CHECK ADD FOREIGN KEY([area_id])
REFERENCES [dbo].[areas] ([id])
GO
ALTER TABLE [dbo].[areas_auxiliares]  WITH CHECK ADD FOREIGN KEY([auxiliar_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[areas_camiones]  WITH CHECK ADD FOREIGN KEY([area_id])
REFERENCES [dbo].[areas] ([id])
GO
ALTER TABLE [dbo].[areas_camiones]  WITH CHECK ADD FOREIGN KEY([camion_id])
REFERENCES [dbo].[camiones] ([id])
GO
ALTER TABLE [dbo].[areas_grupos]  WITH CHECK ADD FOREIGN KEY([area_id])
REFERENCES [dbo].[areas] ([id])
GO
ALTER TABLE [dbo].[areas_grupos]  WITH CHECK ADD FOREIGN KEY([grupo_id])
REFERENCES [dbo].[grupos] ([id])
GO
ALTER TABLE [dbo].[areas_naves]  WITH CHECK ADD FOREIGN KEY([area_id])
REFERENCES [dbo].[areas] ([id])
GO
ALTER TABLE [dbo].[areas_naves]  WITH CHECK ADD FOREIGN KEY([nave_id])
REFERENCES [dbo].[naves] ([id])
GO
ALTER TABLE [dbo].[areas_recintos]  WITH CHECK ADD FOREIGN KEY([area_id])
REFERENCES [dbo].[areas] ([id])
GO
ALTER TABLE [dbo].[areas_recintos]  WITH CHECK ADD FOREIGN KEY([recinto_id])
REFERENCES [dbo].[recintos] ([id])
GO
ALTER TABLE [dbo].[areas_recursos]  WITH CHECK ADD FOREIGN KEY([area_id])
REFERENCES [dbo].[areas] ([id])
GO
ALTER TABLE [dbo].[areas_recursos]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[arte_pesca]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[arte_pesca]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[auxiliares]  WITH CHECK ADD FOREIGN KEY([ciudad_id])
REFERENCES [dbo].[ciudades] ([id])
GO
ALTER TABLE [dbo].[auxiliares]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[auxiliares]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[bodegas]  WITH CHECK ADD FOREIGN KEY([nave_id])
REFERENCES [dbo].[naves] ([id])
GO
ALTER TABLE [dbo].[calibres]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[camiones]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[camiones]  WITH CHECK ADD FOREIGN KEY([transporte_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[ciudades]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[controles_calidad]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[controles_calidad]  WITH CHECK ADD FOREIGN KEY([guia_encabezado_id])
REFERENCES [dbo].[guia_encabezados] ([id])
GO
ALTER TABLE [dbo].[controles_calidad]  WITH CHECK ADD FOREIGN KEY([tratamiento_id])
REFERENCES [dbo].[tratamientos] ([id])
GO
ALTER TABLE [dbo].[controles_calidad]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[descarga_detalles]  WITH CHECK ADD FOREIGN KEY([descarga_encabezado_id])
REFERENCES [dbo].[descarga_encabezados] ([id])
GO
ALTER TABLE [dbo].[descarga_detalles]  WITH CHECK ADD FOREIGN KEY([destinatario_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[descarga_detalles]  WITH CHECK ADD FOREIGN KEY([especie_id])
REFERENCES [dbo].[especies] ([id])
GO
ALTER TABLE [dbo].[descarga_detalles]  WITH CHECK ADD FOREIGN KEY([tcs_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[descarga_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([descarga_detalle_id])
REFERENCES [dbo].[descarga_detalles] ([id])
GO
ALTER TABLE [dbo].[descarga_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([unidad_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[descarga_encabezados]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[descarga_encabezados]  WITH CHECK ADD FOREIGN KEY([movimiento_id])
REFERENCES [dbo].[movimientos] ([id])
GO
ALTER TABLE [dbo].[descarga_encabezados]  WITH CHECK ADD FOREIGN KEY([recalada_id])
REFERENCES [dbo].[recaladas] ([id])
GO
ALTER TABLE [dbo].[descarga_encabezados]  WITH CHECK ADD FOREIGN KEY([tipo_descarga_id])
REFERENCES [dbo].[tipo_descargas] ([id])
GO
ALTER TABLE [dbo].[descarga_encabezados]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[divisiones]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[especies]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[especies_recursos]  WITH CHECK ADD FOREIGN KEY([especie_id])
REFERENCES [dbo].[especies] ([id])
GO
ALTER TABLE [dbo].[especies_recursos]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[folio_detalles]  WITH CHECK ADD FOREIGN KEY([descarga_detalle_id])
REFERENCES [dbo].[descarga_detalles] ([id])
GO
ALTER TABLE [dbo].[folio_detalles]  WITH CHECK ADD FOREIGN KEY([especie_id])
REFERENCES [dbo].[especies] ([id])
GO
ALTER TABLE [dbo].[folio_detalles]  WITH CHECK ADD FOREIGN KEY([folio_encabezado_id])
REFERENCES [dbo].[folio_encabezados] ([id])
GO
ALTER TABLE [dbo].[folio_detalles_lote_encabezados]  WITH CHECK ADD FOREIGN KEY([folio_detalle_id])
REFERENCES [dbo].[folio_detalles] ([id])
GO
ALTER TABLE [dbo].[folio_detalles_lote_encabezados]  WITH CHECK ADD FOREIGN KEY([lote_encabezado_id])
REFERENCES [dbo].[lote_encabezados] ([id])
GO
ALTER TABLE [dbo].[folio_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([folio_detalle_id])
REFERENCES [dbo].[folio_detalles] ([id])
GO
ALTER TABLE [dbo].[folio_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([unidad_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[folio_encabezados]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[folio_encabezados]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[folio_encabezados]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[folio_encabezados]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[grupos]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[grupos]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[grupos_privilegios]  WITH CHECK ADD FOREIGN KEY([grupo_id])
REFERENCES [dbo].[grupos] ([id])
GO
ALTER TABLE [dbo].[grupos_privilegios]  WITH CHECK ADD FOREIGN KEY([privilegio_id])
REFERENCES [dbo].[privilegios] ([id])
GO
ALTER TABLE [dbo].[grupos_usuarios]  WITH CHECK ADD FOREIGN KEY([grupo_id])
REFERENCES [dbo].[grupos] ([id])
GO
ALTER TABLE [dbo].[grupos_usuarios]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[guia_detalles]  WITH CHECK ADD FOREIGN KEY([descarga_detalle_id])
REFERENCES [dbo].[descarga_detalles] ([id])
GO
ALTER TABLE [dbo].[guia_detalles]  WITH CHECK ADD FOREIGN KEY([especie_id])
REFERENCES [dbo].[especies] ([id])
GO
ALTER TABLE [dbo].[guia_detalles]  WITH CHECK ADD FOREIGN KEY([guia_encabezado_id])
REFERENCES [dbo].[guia_encabezados] ([id])
GO
ALTER TABLE [dbo].[guia_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([guia_detalle_id])
REFERENCES [dbo].[guia_detalles] ([id])
GO
ALTER TABLE [dbo].[guia_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([unidad_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([camion_id])
REFERENCES [dbo].[camiones] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([chofer_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([destino_id])
REFERENCES [dbo].[recintos] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([movimiento_id])
REFERENCES [dbo].[movimientos] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([origen_id])
REFERENCES [dbo].[recintos] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[guia_encabezados]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[lote_detalles]  WITH CHECK ADD FOREIGN KEY([calibre_id])
REFERENCES [dbo].[calibres] ([id])
GO
ALTER TABLE [dbo].[lote_detalles]  WITH CHECK ADD FOREIGN KEY([lote_encabezado_id])
REFERENCES [dbo].[lote_encabezados] ([id])
GO
ALTER TABLE [dbo].[lote_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([lote_detalle_id])
REFERENCES [dbo].[lote_detalles] ([id])
GO
ALTER TABLE [dbo].[lote_detalles_unidades]  WITH CHECK ADD FOREIGN KEY([unidad_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[lote_encabezados]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[lote_encabezados]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[lote_encabezados]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[lote_encabezados]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([arte_pesca_id])
REFERENCES [dbo].[arte_pesca] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([capitan_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([nave_id])
REFERENCES [dbo].[naves] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([puerto_id])
REFERENCES [dbo].[puertos] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[mareas1]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[movimientos]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([armador_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([capitan_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([regimen_id])
REFERENCES [dbo].[regimenes] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([representante_id])
REFERENCES [dbo].[auxiliares] ([id])
GO
ALTER TABLE [dbo].[naves]  WITH CHECK ADD FOREIGN KEY([zona_operacion_id])
REFERENCES [dbo].[zona_operaciones] ([id])
GO
ALTER TABLE [dbo].[naves_recursos]  WITH CHECK ADD FOREIGN KEY([nave_id])
REFERENCES [dbo].[naves] ([id])
GO
ALTER TABLE [dbo].[naves_recursos]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[naves_unidades]  WITH CHECK ADD FOREIGN KEY([nave_id])
REFERENCES [dbo].[naves] ([id])
GO
ALTER TABLE [dbo].[naves_unidades]  WITH CHECK ADD FOREIGN KEY([unidad_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[plantas]  WITH CHECK ADD FOREIGN KEY([id])
REFERENCES [dbo].[recintos] ([id])
GO
ALTER TABLE [dbo].[pontones]  WITH CHECK ADD FOREIGN KEY([id])
REFERENCES [dbo].[recintos] ([id])
GO
ALTER TABLE [dbo].[pontones]  WITH CHECK ADD FOREIGN KEY([puerto_id])
REFERENCES [dbo].[puertos] ([id])
GO
ALTER TABLE [dbo].[puertos]  WITH CHECK ADD FOREIGN KEY([id])
REFERENCES [dbo].[recintos] ([id])
GO
ALTER TABLE [dbo].[recaladas]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[recaladas]  WITH CHECK ADD FOREIGN KEY([marea_id])
REFERENCES [dbo].[mareas1] ([id])
GO
ALTER TABLE [dbo].[recaladas]  WITH CHECK ADD FOREIGN KEY([ponton_id])
REFERENCES [dbo].[pontones] ([id])
GO
ALTER TABLE [dbo].[recaladas]  WITH CHECK ADD FOREIGN KEY([usuario_uid])
REFERENCES [dbo].[usuarios] ([uid])
GO
ALTER TABLE [dbo].[recintos]  WITH CHECK ADD FOREIGN KEY([division_id])
REFERENCES [dbo].[divisiones] ([id])
GO
ALTER TABLE [dbo].[recintos]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[recursos]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[recursos]  WITH CHECK ADD FOREIGN KEY([unidad_principal_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[recursos_unidades]  WITH CHECK ADD FOREIGN KEY([recurso_id])
REFERENCES [dbo].[recursos] ([id])
GO
ALTER TABLE [dbo].[recursos_unidades]  WITH CHECK ADD FOREIGN KEY([unidad_id])
REFERENCES [dbo].[unidades] ([id])
GO
ALTER TABLE [dbo].[tipo_descargas]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[tratamientos]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[unidades]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
ALTER TABLE [dbo].[usuarios]  WITH CHECK ADD FOREIGN KEY([estado_id])
REFERENCES [dbo].[estados] ([id])
GO
/****** Object:  StoredProcedure [dbo].[descargas_vs_guias]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 09 10>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- =============================================
CREATE PROCEDURE [dbo].[descargas_vs_guias]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		--CASE WHEN naves.division_id = 1 THEN 'CM PESCA SUR' ELSE 'CM PESCA NORTE' END  AS [DIVISION],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha_recalada [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) AND
		descarga_detalles_unidades.unidad_id = 1
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA],
		CASE
			WHEN GU.unidad_id = 1 THEN 'TONELADAS'
			ELSE 'CAJAS'
			END  AS [UN.MEDIDA GUIA]
INTO #PASO02
FROM	([RMPCORONELv2].[dbo].[guia_encabezados] GE 
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GD 
			ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles_unidades] GU 
			ON GU.guia_detalle_id = GD.id,
		[RMPCORONELv2].[dbo].[descarga_detalles] DD,
		[RMPCORONELv2].[dbo].[descarga_encabezados] DE,
		[RMPCORONELv2].[dbo].v_pontones v_pontones,
		[RMPCORONELv2].[dbo].v_plantas v_plantas,
		[RMPCORONELv2].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id 

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre_razon_social [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELv2].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELv2].[dbo].v_camiones CAMION,
		[RMPCORONELv2].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		--#PASO01.[DIVISION],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		--#PASO03.[PATENTE CAMION],
		--#PASO03.[TIPO CAMION],
		--#PASO03.TRANSPORTES,
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO02.[UN.MEDIDA GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		--#PASO01.[PUERTO],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO]
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
	  --LEFT JOIN #PASO03 ON #PASO02.[NRO GUIA] = #PASO03.[NRO GUIA]
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		--#PASO03.[DIVISION],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[UN.MEDIDA GUIA],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO]
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
/****** Object:  StoredProcedure [dbo].[SP_002_descargas_vs_guias_filtro_fechas]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 10 22>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, 
--               procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- Filtro Fechas: 3 meses atrás
-- =============================================
CREATE PROCEDURE [dbo].[SP_002_descargas_vs_guias_filtro_fechas]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) AND
		YEAR(recaladas.fecha)  = YEAR(GETDATE()) AND
		MONTH(recaladas.fecha) >= MONTH(GETDATE())-3
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA]
INTO #PASO02
FROM	([RMPCORONELv2].[dbo].[guia_encabezados] GE 
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GD 
			ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles_unidades] GU 
			ON GU.guia_detalle_id = GD.id,
		[RMPCORONELv2].[dbo].[descarga_detalles] DD,
		[RMPCORONELv2].[dbo].[descarga_encabezados] DE,
		[RMPCORONELv2].[dbo].v_pontones v_pontones,
		[RMPCORONELv2].[dbo].v_plantas v_plantas,
		[RMPCORONELv2].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id 

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELv2].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELv2].[dbo].v_camiones CAMION,
		[RMPCORONELv2].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		--#PASO03.[PATENTE CAMION],
		--#PASO03.[TIPO CAMION],
		--#PASO03.TRANSPORTES,
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		--#PASO01.[PUERTO],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO]
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
	  --LEFT JOIN #PASO03 ON #PASO02.[NRO GUIA] = #PASO03.[NRO GUIA]
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO]
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
/****** Object:  StoredProcedure [dbo].[SP_003_descargas_vs_guias_filtro_fechas_valdivia]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 10 22>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, 
--               procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- Filtro Fechas: 3 meses atrás
-- Ubicación:		Valdivia
-- =============================================
CREATE PROCEDURE [dbo].[SP_003_descargas_vs_guias_filtro_fechas_valdivia]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) AND
		YEAR(recaladas.fecha)  = YEAR(GETDATE()) AND
		MONTH(recaladas.fecha) >= MONTH(GETDATE())-3 AND
		recintos.nombre = 'DESCARGA VALDIVIA'
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA]
INTO #PASO02
FROM	([RMPCORONELv2].[dbo].[guia_encabezados] GE 
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GD 
			ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles_unidades] GU 
			ON GU.guia_detalle_id = GD.id,
		[RMPCORONELv2].[dbo].[descarga_detalles] DD,
		[RMPCORONELv2].[dbo].[descarga_encabezados] DE,
		[RMPCORONELv2].[dbo].v_pontones v_pontones,
		[RMPCORONELv2].[dbo].v_plantas v_plantas,
		[RMPCORONELv2].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id 

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELv2].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELv2].[dbo].v_camiones CAMION,
		[RMPCORONELv2].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		--#PASO03.[PATENTE CAMION],
		--#PASO03.[TIPO CAMION],
		--#PASO03.TRANSPORTES,
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		--#PASO01.[PUERTO],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO]
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
	  --LEFT JOIN #PASO03 ON #PASO02.[NRO GUIA] = #PASO03.[NRO GUIA]
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO]
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
/****** Object:  StoredProcedure [dbo].[SP_004_descargas_vs_guias_filtro_fechas_romana_crnl]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 10 22>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, 
--               procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- Filtro Fechas: 3 meses atrás
-- =============================================
CREATE PROCEDURE [dbo].[SP_004_descargas_vs_guias_filtro_fechas_romana_crnl]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) AND
		YEAR(recaladas.fecha)  = YEAR(GETDATE()) AND
		MONTH(recaladas.fecha) >= MONTH(GETDATE())-3 AND
		arte_pesca.nombre <> 'ARRASTRE'
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA]
INTO #PASO02
FROM	([RMPCORONELv2].[dbo].[guia_encabezados] GE 
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GD 
			ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles_unidades] GU 
			ON GU.guia_detalle_id = GD.id,
		[RMPCORONELv2].[dbo].[descarga_detalles] DD,
		[RMPCORONELv2].[dbo].[descarga_encabezados] DE,
		[RMPCORONELv2].[dbo].v_pontones v_pontones,
		[RMPCORONELv2].[dbo].v_plantas v_plantas,
		[RMPCORONELv2].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id 

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELv2].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELv2].[dbo].v_camiones CAMION,
		[RMPCORONELv2].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		--#PASO03.[PATENTE CAMION],
		--#PASO03.[TIPO CAMION],
		--#PASO03.TRANSPORTES,
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		--#PASO01.[PUERTO],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO]
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
	  --LEFT JOIN #PASO03 ON #PASO02.[NRO GUIA] = #PASO03.[NRO GUIA]
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO]
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
/****** Object:  StoredProcedure [dbo].[SP_005_descargas_vs_guias_filtro_fechas_artesanal]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 10 22>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, 
--               procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- Filtro Fechas: 3 meses atrás
-- =============================================
CREATE PROCEDURE [dbo].[SP_005_descargas_vs_guias_filtro_fechas_artesanal]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) AND
		YEAR(recaladas.fecha)  = YEAR(GETDATE()) AND
		MONTH(recaladas.fecha) >= MONTH(GETDATE())-3 AND
		tipo_descargas.nombre <> 'DESCARGA INDUSTRIAL'
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA]
INTO #PASO02
FROM	([RMPCORONELv2].[dbo].[guia_encabezados] GE 
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GD 
			ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles_unidades] GU 
			ON GU.guia_detalle_id = GD.id,
		[RMPCORONELv2].[dbo].[descarga_detalles] DD,
		[RMPCORONELv2].[dbo].[descarga_encabezados] DE,
		[RMPCORONELv2].[dbo].v_pontones v_pontones,
		[RMPCORONELv2].[dbo].v_plantas v_plantas,
		[RMPCORONELv2].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id 

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELv2].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELv2].[dbo].v_camiones CAMION,
		[RMPCORONELv2].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		--#PASO03.[PATENTE CAMION],
		--#PASO03.[TIPO CAMION],
		--#PASO03.TRANSPORTES,
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		--#PASO01.[PUERTO],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO]
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
	  --LEFT JOIN #PASO03 ON #PASO02.[NRO GUIA] = #PASO03.[NRO GUIA]
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO]
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
/****** Object:  StoredProcedure [dbo].[SP_006_descargas_vs_guias_calidad]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 09 10>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- =============================================
CREATE PROCEDURE [dbo].[SP_006_descargas_vs_guias_calidad]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha_recalada [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id)
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA],
		TR.nombre [TRATAMIENTO APLICADO],
		CC.TVN,
		CC.agua [% AGUA],
		CC.ph [pH],
		CC.c [ºC],
		CC.n_litro [Nº/Litro],
		CC.talla [Talla],
		CC.peso [Peso],
		CC.moda [Moda],
		CC.cms [< 10 cms],
		CC.observaciones [Observaciones]		
INTO #PASO02
FROM	((([RMPCORONELv2].[dbo].[guia_encabezados] GE LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GD ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles_unidades] GU ON GU.guia_detalle_id = GD.id) 
		LEFT JOIN [RMPCORONELv2].[dbo].[controles_calidad] CC ON CC.guia_encabezado_id = GE.id)
		LEFT JOIN [RMPCORONELv2].[dbo].[tratamientos] TR ON TR.id = CC.tratamiento_id,
		[RMPCORONELv2].[dbo].[descarga_detalles] DD,
		[RMPCORONELv2].[dbo].[descarga_encabezados] DE,
		[RMPCORONELv2].[dbo].v_pontones v_pontones,
		[RMPCORONELv2].[dbo].v_plantas v_plantas,
		[RMPCORONELv2].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre_razon_social [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELv2].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELv2].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELv2].[dbo].v_camiones CAMION,
		[RMPCORONELv2].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO],
		#PASO02.[TRATAMIENTO APLICADO],
		#PASO02.TVN,
		#PASO02.[% AGUA],
		#PASO02.[pH],
		#PASO02.[ºC],
		#PASO02.[Nº/Litro],
		#PASO02.[Talla],
		#PASO02.[Peso],
		#PASO02.[Moda],
		#PASO02.[< 10 cms],
		#PASO02.[Observaciones]	
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO],
		#PASO03.[TRATAMIENTO APLICADO],
		#PASO03.TVN,
		#PASO03.[% AGUA],
		#PASO03.[pH],
		#PASO03.[ºC],
		#PASO03.[Nº/Litro],
		#PASO03.[Talla],
		#PASO03.[Peso],
		#PASO03.[Moda],
		#PASO03.[< 10 cms],
		#PASO03.[Observaciones]	
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
/****** Object:  StoredProcedure [dbo].[SP_007_descarga_langos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 09 10>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- =============================================
CREATE PROCEDURE [dbo].[SP_007_descarga_langos]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
--IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
--	DROP TABLE #PASO02
--IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
--	DROP TABLE #PASO03
--IF OBJECT_ID('tempdb..#PASO04') IS NOT NULL 
--	DROP TABLE #PASO04
--IF OBJECT_ID('tempdb..#PASO05') IS NOT NULL 
--	DROP TABLE #PASO05	

SELECT	DE.codigo_descarga [CoDi]
		,DD.especie_id [CoEspecie]
		,CASE WHEN DDU.unidad_id = 1 THEN 'Ton' ELSE 'Caj' END  AS [Unidad]
		,DD.destinatario_id [CoDestino]
		,DDU.cantidad [Cantidad]
		,DE.recalada_id [RECALADA ID]
		,DD.id [DESCARGA DETALLE ID]
		,ESP.nombre [Especie]
		,DD.id descarga_detalle_id
INTO #PASO01		
FROM ([RMPCORONELv2].[dbo].[descarga_detalles_unidades] DDU LEFT JOIN [RMPCORONELv2].[dbo].[descarga_detalles] DD ON DDU.descarga_detalle_id = DD.id) 
	LEFT JOIN [RMPCORONELv2].[dbo].[descarga_encabezados] DE  ON DD.descarga_encabezado_id = DE.id, [RMPCORONELv2].[dbo].[especies] ESP
WHERE ESP.id=DD.especie_id

SELECT  #PASO01.descarga_detalle_id
		,#PASO01.Codi
		,#PASO01.CoEspecie
		,#PASO01.Unidad
		,#PASO01.CoDestino
		,#PASO01.Cantidad
		,MA.id				[CoMarea]
		,#PASO01.Especie
		,NA.nombre			[Nave]
		,MA.fecha_zarpe		[Fecha Zarpe]
		,PUE.nombre			[Puerto Zarpe]
		--,DATEADD(day, 2, RE.fecha_recalada) [Fecha Prueba]
		,RE.fecha_recalada	[Fecha Recalada] 
		,PON.nombre			[Ponton Recalada]
--INTO #PASO02		
FROM	([RMPCORONELv2].[dbo].[recaladas] RE LEFT JOIN [RMPCORONELv2].[dbo].[mareas] MA ON MA.id = RE.marea_id)
		LEFT JOIN #PASO01 ON RE.id = #PASO01.[RECALADA ID]
		,[RMPCORONELv2].[dbo].[naves] NA
		,[RMPCORONELv2].[dbo].[v_pontones] PON
		,[RMPCORONELv2].[dbo].[v_puertos] PUE
WHERE	NA.id= MA.nave_id
		AND PON.id=RE.ponton_id
		AND PUE.id=MA.puerto_id
		AND MA.arte_pesca_id = 1
ORDER BY [Fecha Recalada]


--SELECT		FE.nro_folio		[FOLIO NRO]
--			,FE.calibre			[FOLIO CALIBRE]
--			,FE.fecha_recepcion [FOLIO FECHA RECEPCION]
--			,ESP.nombre			[FOLIO ESPECIE]
--			,FD.secuencial		[FOLIO SECUENCIAL]
--			,FD.fecha_produccion [FOLIO FECHA PRODUCCION] 
--			,FDU.cantidad		[FOLIO CANTIDAD]
--			,CASE WHEN FDU.unidad_id = 1 THEN 'TONELADAS' ELSE 'CAJAS' END  AS [FOLIO UN.MEDIDA]
--			,FD.descarga_detalle_id [DD_ID]
--			,FD.id [FOLIO DETALLE ID]
--INTO #PASO03
--FROM ([RMPCORONELv2].[dbo].[folio_detalles_unidades] FDU LEFT JOIN [RMPCORONELv2].[dbo].[folio_detalles] FD
--ON FD.id = FDU.folio_detalle_id) LEFT JOIN [RMPCORONELv2].[dbo].[folio_encabezados] FE ON FE.id = FD.folio_encabezado_id, [RMPCORONELv2].[dbo].[especies] ESP
--WHERE FD.especie_id = ESP.id

--SELECT	#PASO03.*, #PASO02.*
--INTO #PASO04
--FROM	#PASO03 LEFT JOIN #PASO02 ON #PASO03.[DD_ID] = #PASO02.descarga_detalle_id

--SELECT	LE.lote			[LOTE]
--		,LE.sub_codigo  [LOTE SUBCODIGO]
--		,LD.pallet		[PALLET]
--		,CAL.nombre		[CALIBRE]
--		,LDU.cantidad	[LOTE CANTIDAD]
--		,CASE WHEN LDU.unidad_id = 3 THEN 'KILOS PT' ELSE 'CAJAS PT' END AS [LOTE UN.MEDIDA]
--		,LE.id [LOTE ENCABEZADO ID]
--INTO #PASO05
--FROM ([RMPCORONELv2].[dbo].[lote_detalles_unidades] LDU LEFT JOIN [RMPCORONELv2].[dbo].[lote_detalles] LD 
--ON LDU.lote_detalle_id = LD.id) LEFT JOIN [RMPCORONELv2].[dbo].[lote_encabezados] LE ON LE.id= LD.lote_encabezado_id,
--[RMPCORONELv2].[dbo].calibres CAL
--WHERE  CAL.id = LD.calibre_id

--/****** Script para el comando SelectTopNRows de SSMS  ******/
--SELECT DISTINCT #PASO04.*,#PASO05.*
--FROM #PASO04,#PASO05,[RMPCORONELv2].[dbo].[folio_detalles_lote_encabezados] FLE
--WHERE #PASO05.[LOTE ENCABEZADO ID]= FLE.[lote_encabezado_id]
--AND #PASO04.[FOLIO DETALLE ID] = FLE.[folio_detalle_id]
----
GO
/****** Object:  StoredProcedure [dbo].[SP_008_produccion_langos]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 09 10>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- =============================================
CREATE PROCEDURE [dbo].[SP_008_produccion_langos]   
AS

IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO04') IS NOT NULL DROP TABLE #PASO03

SELECT	--FE.id [FE_Id]
		FD.id [FD_Id]
		,FD.descarga_detalle_id [DD_Id]
		,FE.nro_folio [FE_NumFolio]
		,FE.fecha_recepcion [FE_FecFolio]
		,ESP.nombre [FE_Especie]
		--,FE.observaciones [FE_Observ]
		,FD.secuencial [FD_NroSec]
		,FD.fecha_produccion [FD_FechaProd]
		,CASE WHEN FDU.unidad_id = 1 THEN 'KgsPro' ELSE 'CjsPro' END  AS [Unidad_Pro]
		,CASE WHEN FDU.unidad_id = 1 THEN FDU.cantidad ELSE 0 END  AS [KgsPro1]
		,CASE WHEN FDU.unidad_id = 2 THEN FDU.cantidad ELSE 0 END  AS [CjsPro1]
		,FE.calibre	 [FE_Calibre]
INTO #PASO01
FROM	((	RMPCORONELv2.dbo.folio_encabezados FE LEFT JOIN 
			RMPCORONELv2.dbo.folio_detalles FD ON FD.folio_encabezado_id = FE.id)
			LEFT JOIN RMPCORONELv2.dbo.folio_detalles_unidades FDU ON Fdu.folio_detalle_id = FD.ID),
			RMPCORONELv2.dbo.especies ESP
WHERE ESP.id = FD.especie_id
ORDER BY FE.fecha_recepcion, FD.id

SELECT	LE.id [LE_Id]
		,LD.id [LD_Id]
		,LE.lote [LE_Lote]
		,LD.pallet [LD_Pallet]
		,CAL.nombre [LD_Calibre]
		,CASE WHEN LDU.unidad_id = 3 THEN 'KilosPT' ELSE 'CajasPT' END AS [CantPtUni]
		,CASE WHEN LDU.unidad_id = 3 THEN LDU.cantidad ELSE 0 END AS [KgsPT1]
		,CASE WHEN LDU.unidad_id = 4 THEN LDU.cantidad ELSE 0 END AS [CjsPT1]
INTO #PASO02
FROM	(	RMPCORONELv2.dbo.lote_encabezados LE LEFT JOIN 
			RMPCORONELv2.dbo.lote_detalles LD ON LD.lote_encabezado_id = LE.id)
			LEFT JOIN RMPCORONELv2.dbo.lote_detalles_unidades LDU ON ldu.lote_detalle_id = LD.ID
		,RMPCORONELv2.dbo.calibres CAL
WHERE CAL.id = LD.calibre_id
ORDER BY LE.id ASC

SELECT  descarga_detalles.id DESC_ID
		,mareas.id [ID MAREA],
		--arte_pesca.nombre [ARTE PESCA],  
		--descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE]
		,descarga_detalles.destinatario_id
		,CASE WHEN descarga_detalles_unidades.unidad_id = 1 THEN 'Ton' ELSE 'Cjs' END  AS [UnidadDI]
		,CASE WHEN descarga_detalles_unidades.unidad_id = 1 THEN descarga_detalles_unidades.cantidad ELSE 0 END  AS [TonDI1]
		,CASE WHEN descarga_detalles_unidades.unidad_id = 2 THEN descarga_detalles_unidades.cantidad ELSE 0 END  AS [CjsDI1]
		--,descarga_detalles.zona_pesca [ZONA PESCA],
		--v_destinatarios.nombre_razon_social [DESTINO PESCA],
		,v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		--zonas_op.nombre [ZONA OPERACION],
		--v_tcs.nombre_razon_social [TCS],
		--descarga_detalles.resolucion [RESOLUCION],
		--v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		--v_armadores.nombre_razon_social [NOM_ARM_1],
		--v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha_recalada [FECHA RECALADA]
		--descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		--tipo_descargas.nombre [TIPO DESCARGA],
		--descarga_encabezados.fecha_pesca [FECHA PESCA]   
INTO #PASO03
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) 
		--AND recintos.nombre = 'Tome | CPS | Muelle 1'
		AND arte_pesca.nombre = 'ARRASTRE'
		AND descarga_detalles.destinatario_id <> 667 
		AND descarga_detalles.destinatario_id <> 820  --ifop
		AND especies.id <> 14 -- lenguado
		AND especies.id <> 15 -- merluza
ORDER BY descarga_detalles.id


SELECT #PASO01.*,#PASO02.* 
INTO #PASO04
FROM #PASO01 INNER JOIN [RMPCORONELv2].[dbo].[folio_detalles_lote_encabezados] FLE ON #PASO01.FD_Id = FLE.folio_detalle_id
		RIGHT JOIN #PASO02 ON #PASO02.LE_Id = FLE.lote_encabezado_id
GROUP BY #PASO01.FD_Id,#PASO01.[DD_Id],#PASO01.FE_NumFolio,#PASO01.FE_FecFolio,#PASO01.FE_Especie,#PASO01.FD_NroSec,#PASO01.FD_FechaProd,#PASO01.Unidad_Pro,#PASO01.KgsPro1
		 ,#PASO01.CjsPro1,#PASO01.FE_Calibre,#PASO02.LE_Id,#PASO02.LD_Id,#PASO02.LE_Lote,#PASO02.LD_Pallet,#PASO02.LD_Calibre,#PASO02.CantPtUni,#PASO02.KgsPT1,#PASO02.CjsPT1
ORDER BY #PASO01.FE_FecFolio
		
SELECT #PASO04.*,#PASO03.* 
FROM #PASO04 RIGHT JOIN #PASO03 ON #PASO04.DD_Id = #PASO03.DESC_ID
GROUP BY #PASO04.FD_Id
		,#PASO04.DD_Id
		,#PASO04.FE_NumFolio
		,#PASO04.FE_FecFolio
		,#PASO04.FE_Especie
		,#PASO04.FD_NroSec
		,#PASO04.FD_FechaProd
		,#PASO04.Unidad_Pro
		,#PASO04.KgsPro1
		,#PASO04.CjsPro1
		,#PASO04.FE_Calibre
		,#PASO04.LE_Id
		,#PASO04.LD_Id
		,#paso04.LE_Lote
		,#PASO04.LD_Pallet
		,#PASO04.LD_Calibre
		,#PASO04.CantPtUni
		,#PASO04.KgsPT1
		,#PASO04.CjsPT1
		,#PASO03.DESC_ID
		,#PASO03.[ID MAREA]
		,#paso03.LANCHA
		,#paso03.[DI/DA/VALE]
		,#PASO03.ESPECIE
		,#PASO03.destinatario_id
		,#paso03.[UnidadDI]
		,#paso03.TonDI1
		,#paso03.CjsDI1
		,#PASO03.PUERTO
		,#PASO03.DESCARGA
		,#paso03.[FECHA ZARPE]
		,#PASO03.[FECHA RECALADA]		
--order BY #PASO04.FD_Id
--		,#PASO04.DD_Id
--		,#PASO04.FE_NumFolio
--		,#PASO04.FE_FecFolio
--		,#PASO04.FE_Especie
--		,#PASO04.FD_NroSec
--		,#PASO04.FD_FechaProd
--		,#PASO04.KgsPro1
--		,#PASO04.CjsPro1
--		,#PASO04.FE_Calibre
--		,#PASO04.LE_Id
--		,#PASO04.LE_Lote
--		,#PASO04.LD_Pallet
--		,#PASO04.LD_Calibre
--		,#PASO04.KgsPT1
--		,#PASO04.CjsPT1
--		,#PASO03.DESC_ID
--		,#PASO03.[ID MAREA]
--		,#paso03.LANCHA
--		,#paso03.[DI/DA/VALE]
--		,#PASO03.ESPECIE
--		,#paso03.TonDI1
--		,#paso03.CjsDI1
--		,#PASO03.PUERTO
--		,#PASO03.DESCARGA
--		,#paso03.[FECHA ZARPE]
--		,#PASO03.[FECHA RECALADA]		
		
--GROUP BY #PASO01.FD_Id
--		 ,#PASO01.[DD_Id]
--		 ,#PASO01.FE_NumFolio
--		 ,#PASO01.FE_FecFolio
--		 ,#PASO01.FE_Especie
--		 ,#PASO01.FD_NroSec
--		 ,#PASO01.FD_FechaProd
--		 ,#PASO01.KgsPro1
--		 ,#PASO01.CjsPro1
--		 ,#PASO01.FE_Calibre
--		 ,#PASO02.LE_Id
--		 ,#PASO02.LE_Lote
--	     ,#PASO02.LD_Pallet
--		 ,#PASO02.LD_Calibre
--		 ,#PASO02.KgsPT
--		 ,#PASO02.CjsPT
--ORDER BY #PASO04.FE_FecFolio
		
--DECLARE @folio_detalle_id int
--DECLARE @folio_detalle_id_anterior int
----DECLARE @lote_encabezado_id int
----DECLARE @lote_encabezado_id_anterior int
--SET @folio_detalle_id_anterior = 0
----SET @lote_encabezado_id_anterior = 0

--DECLARE folio_cursor CURSOR FOR 
--SELECT FD_Id FROM #PASO03
--OPEN folio_cursor

--FETCH NEXT FROM folio_cursor INTO @folio_detalle_id--, @lote_encabezado_id

--WHILE @@FETCH_STATUS = 0
--BEGIN
--		IF @folio_detalle_id_anterior <> @folio_detalle_id 
--		begin
--			PRINT @folio_detalle_id_anterior 
--			PRINT ' - '
--			PRINT @folio_detalle_id 
--			INSERT INTO #PASO04(FOLIO_DETALLE_ID,[NRO FOLIO],[FECHA RECEPCION],[ESPECIE],[NRO SECUENCIAL],[FECHA PRODUCCION],[KgsPro],[CjsPro],CALIBRE,LOTE_ENCABEZADO_ID)
--			SELECT	#PASO03.FD_Id,#PASO03.FE_NumFolio,#PASO03.FE_FecFolio,#PASO03.FE_Especie,#PASO03.FD_NroSec,#PASO03.FD_FechaProd,#PASO03.KgsPro,#PASO03.CjsPro,#PASO03.FE_Calibre,#PASO03.LE_Id
--			FROM #PASO03 WHERE @folio_detalle_id = #PASO03.FD_Id
--		end
--		ELSE
--		begin
--			PRINT @folio_detalle_id_anterior 
--			PRINT ' - '
--			PRINT @folio_detalle_id 
--			INSERT INTO #PASO04(FOLIO_DETALLE_ID,[NRO FOLIO],[FECHA RECEPCION],[ESPECIE],[NRO SECUENCIAL],[FECHA PRODUCCION],[KgsPro],[CjsPro],CALIBRE,LOTE_ENCABEZADO_ID)
--			SELECT	#PASO03.FD_Id,#PASO03.FE_NumFolio,#PASO03.FE_FecFolio,#PASO03.FE_Especie,#PASO03.FD_NroSec,#PASO03.FD_FechaProd,0,1,#PASO03.FE_Calibre,#PASO03.LE_Id
--			FROM #PASO03 WHERE @folio_detalle_id = #PASO03.FD_Id
--		end 
--			SET @folio_detalle_id_anterior = @folio_detalle_id
--			FETCH NEXT FROM folio_cursor INTO @folio_detalle_id--, @lote_encabezado_id
--END 
--CLOSE folio_cursor
--DEALLOCATE folio_cursor

--SELECT * FROM #PASO04 ORDER BY #PASO04.FOLIO_DETALLE_ID




GO
/****** Object:  StoredProcedure [dbo].[SP_008_produccion_langos_v3]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 09 10>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- =============================================
CREATE PROCEDURE [dbo].[SP_008_produccion_langos_v3]   
AS

IF OBJECT_ID('tempdb..#PASO01_MAREAS') IS NOT NULL DROP TABLE #PASO01_MAREAS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02_FOLIOS') IS NOT NULL DROP TABLE #PASO02_FOLIOS
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03_LOTES') IS NOT NULL DROP TABLE #PASO03_LOTES
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO04') IS NOT NULL DROP TABLE #PASO04
IF OBJECT_ID('tempdb..#FOLSEC') IS NOT NULL DROP TABLE #FOLSEC

SELECT  descarga_detalles.id DESC_ID
		,mareas.id [ID MAREA]
		,naves.nombre [LANCHA]
		,descarga_encabezados.codigo_descarga [DI/DA/VALE]
		,especies.nombre [ESPECIE]
		,descarga_detalles.destinatario_id
		,CASE WHEN descarga_detalles_unidades.unidad_id = 1 THEN descarga_detalles_unidades.cantidad ELSE 0 END  AS [TonDI1]
		,CASE WHEN descarga_detalles_unidades.unidad_id = 2 THEN descarga_detalles_unidades.cantidad ELSE 0 END  AS [CjsDI1]
		,v_puertos.nombre [PUERTO]
		,recintos.nombre [DESCARGA]
		,mareas.fecha_zarpe [FECHA ZARPE]
		,recaladas.fecha_recalada [FECHA RECALADA]
INTO #PASO01_MAREAS
FROM	(RMPCORONELv2.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELv2.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELv2.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELv2.dbo.recaladas recaladas,
		RMPCORONELv2.dbo.mareas mareas,
		RMPCORONELv2.dbo.arte_pesca,
		RMPCORONELv2.dbo.naves naves,
		RMPCORONELv2.dbo.especies especies,
		RMPCORONELv2.dbo.recintos recintos,
		RMPCORONELv2.dbo.tipo_descargas tipo_descargas,
		RMPCORONELv2.dbo.v_puertos v_puertos,
		RMPCORONELv2.dbo.v_tcs v_tcs,
		RMPCORONELv2.dbo.v_destinatarios,
		RMPCORONELv2.dbo.zona_operaciones zonas_op,
		RMPCORONELv2.dbo.v_armadores,
		RMPCORONELv2.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) 
		AND arte_pesca.nombre = 'ARRASTRE'
		AND descarga_detalles.destinatario_id <> 667 
		AND descarga_detalles.destinatario_id <> 820  --ifop
		AND especies.id <> 14 -- lenguado
		AND especies.id <> 15 -- merluza
ORDER BY descarga_detalles.id,mareas.id,naves.nombre,descarga_encabezados.codigo_descarga,especies.nombre,descarga_detalles.destinatario_id
		,descarga_detalles_unidades.unidad_id,descarga_detalles_unidades.cantidad,v_puertos.nombre,recintos.nombre,mareas.fecha_zarpe,recaladas.fecha_recalada

DECLARE @desc_dtalleid int,@desc_dtalleid_ant int,@marea_id int,@lancha_nombre varchar(40),@nro_di varchar(10),
		@especie_nombre varchar(40), @dest_id int,@tondi decimal(10,6),@cajasdi decimal (10,6),@puerto_nombre varchar(40),
		@descarga varchar(40),@fecha_z datetime,@fecha_r datetime

SELECT TOP 1 * INTO #PASO01 FROM #PASO01_MAREAS

DECLARE mareas_cursor CURSOR FOR 
SELECT * FROM #PASO01_MAREAS
OPEN mareas_cursor
FETCH NEXT FROM mareas_cursor INTO	@desc_dtalleid,@marea_id,@lancha_nombre,@nro_di,@especie_nombre,@dest_id,@tondi,@cajasdi,@puerto_nombre,@descarga,@fecha_z,@fecha_r
SET @desc_dtalleid_ant = @desc_dtalleid
FETCH NEXT FROM mareas_cursor INTO	@desc_dtalleid,@marea_id,@lancha_nombre,@nro_di,@especie_nombre,@dest_id,@tondi,@cajasdi,@puerto_nombre,@descarga,@fecha_z,@fecha_r

WHILE @@FETCH_STATUS = 0
BEGIN

IF @desc_dtalleid_ant = @desc_dtalleid  
	BEGIN 
		UPDATE #PASO01 SET [CjsDI1] = @cajasdi WHERE DESC_ID = @desc_dtalleid
	END
ELSE 
	BEGIN 
		INSERT INTO #PASO01 VALUES (@desc_dtalleid,@marea_id,@lancha_nombre,@nro_di,@especie_nombre,@dest_id,@tondi,@cajasdi,@puerto_nombre,@descarga,@fecha_z,@fecha_r)
		SET @desc_dtalleid_ant = @desc_dtalleid		
	END

FETCH NEXT FROM mareas_cursor INTO @desc_dtalleid,@marea_id,@lancha_nombre,@nro_di,@especie_nombre,@dest_id,@tondi,@cajasdi,@puerto_nombre,@descarga,@fecha_z,@fecha_r
END 
CLOSE mareas_cursor;
DEALLOCATE mareas_cursor;

SELECT	FD.descarga_detalle_id [DD_Id]
		,FD.id [FD_Id]
		,FE.nro_folio [FE_NumFolio]
		,FE.fecha_recepcion [FE_FecFolio]
		,ESP.nombre [FE_Especie]
		,FD.secuencial [FD_NroSec]
		,FD.fecha_produccion [FD_FechaProd]
		,CASE WHEN FDU.unidad_id = 1 THEN FDU.cantidad ELSE 0 END  AS [KgsPro]
		,CASE WHEN FDU.unidad_id = 2 THEN FDU.cantidad ELSE 0 END  AS [CjsPro]
		,FE.calibre	 [FE_Calibre]
INTO #PASO02_FOLIOS
FROM	((	RMPCORONELv2.dbo.folio_encabezados FE LEFT JOIN 
			RMPCORONELv2.dbo.folio_detalles FD ON FD.folio_encabezado_id = FE.id)
			LEFT JOIN RMPCORONELv2.dbo.folio_detalles_unidades FDU ON Fdu.folio_detalle_id = FD.ID),
			RMPCORONELv2.dbo.especies ESP
WHERE ESP.id = FD.especie_id
ORDER BY FD.id

DECLARE @fol_id int, @fol_id_ant int, @desc_dtalleid_fol int, @nro_fol varchar(6), @fec_recep datetime, @especie varchar(40),
		@secuenc int, @fecha_prod datetime, @KgsPro decimal(10,6), @CjsPro decimal(10,6), @calibre int

SELECT TOP 1 * INTO #PASO02 FROM #PASO02_FOLIOS

DECLARE folios_cursor CURSOR FOR 
SELECT * FROM #PASO02_FOLIOS
OPEN folios_cursor
FETCH NEXT FROM folios_cursor INTO @desc_dtalleid_fol,@fol_id,@nro_fol,@fec_recep,@especie,@secuenc,@fecha_prod,@KgsPro,@CjsPro,@calibre
SET @fol_id_ant = @fol_id
FETCH NEXT FROM folios_cursor INTO @desc_dtalleid_fol,@fol_id,@nro_fol,@fec_recep,@especie,@secuenc,@fecha_prod,@KgsPro,@CjsPro,@calibre

WHILE @@FETCH_STATUS = 0
BEGIN

IF @fol_id_ant = @fol_id  
	BEGIN 
		UPDATE #PASO02 SET [CjsPro] = @CjsPro WHERE [FD_Id] = @fol_id
	END
ELSE 
	BEGIN 
		INSERT INTO #PASO02 VALUES (@desc_dtalleid_fol,@fol_id,@nro_fol,@fec_recep,@especie,@secuenc,@fecha_prod,@KgsPro,@CjsPro,@calibre)
		SET @fol_id_ant = @fol_id	
	END

FETCH NEXT FROM folios_cursor INTO @desc_dtalleid_fol,@fol_id,@nro_fol,@fec_recep,@especie,@secuenc,@fecha_prod,@KgsPro,@CjsPro,@calibre
END 
CLOSE folios_cursor;
DEALLOCATE folios_cursor;

SELECT	LE.id [LE_Id]
		,LD.id [LD_Id]
		,LE.lote [LE_Lote]
		,LD.pallet [LD_Pallet]
		,CAL.nombre [LD_Calibre]
		,CASE WHEN LDU.unidad_id = 3 THEN LDU.cantidad ELSE 0 END AS [KgsPT]
		,CASE WHEN LDU.unidad_id = 4 THEN LDU.cantidad ELSE 0 END AS [CjsPT]
INTO #PASO03_LOTES
FROM	(	RMPCORONELv2.dbo.lote_encabezados LE LEFT JOIN 
			RMPCORONELv2.dbo.lote_detalles LD ON LD.lote_encabezado_id = LE.id)
			LEFT JOIN RMPCORONELv2.dbo.lote_detalles_unidades LDU ON ldu.lote_detalle_id = LD.ID
		,RMPCORONELv2.dbo.calibres CAL
WHERE CAL.id = LD.calibre_id
ORDER BY LD.id ASC

DECLARE @lote_id int, @lote_id_ant int, @lote_enc_id int, @lote_nombre varchar(15),@palet varchar(30), @ldcalibre varchar(20), 
		@KPT decimal(10,3), @CPT decimal(10,3)

SELECT TOP 1 * INTO #PASO03 FROM #PASO03_LOTES

DECLARE lotes_cursor CURSOR FOR 
SELECT * FROM #PASO03_LOTES
OPEN lotes_cursor
FETCH NEXT FROM lotes_cursor INTO @lote_enc_id, @lote_id, @lote_nombre,@palet,@ldcalibre,@KPT,@CPT
SET @lote_id_ant = @lote_id
FETCH NEXT FROM lotes_cursor INTO @lote_enc_id, @lote_id, @lote_nombre,@palet,@ldcalibre,@KPT,@CPT

WHILE @@FETCH_STATUS = 0
BEGIN

IF @lote_id_ant = @lote_id
	BEGIN 
		UPDATE #PASO03 SET [CjsPT] = @CPT WHERE [LD_Id] = @lote_id
	END
ELSE 
	BEGIN 
		INSERT INTO #PASO03 VALUES (@lote_enc_id, @lote_id, @lote_nombre,@palet,@ldcalibre,@KPT,@CPT)
		SET @lote_id_ant = @lote_id
	END

FETCH NEXT FROM lotes_cursor INTO @lote_enc_id, @lote_id, @lote_nombre,@palet,@ldcalibre,@KPT,@CPT
END 
CLOSE lotes_cursor;
DEALLOCATE lotes_cursor;

---Se junta Folios y Lotes a través de la tabla folio_detalles_lote_encabezados
SELECT #PASO02.*, #PASO03.* 
INTO #PASO04
FROM #PASO02 INNER JOIN [RMPCORONELv2].[dbo].[folio_detalles_lote_encabezados] FLE ON #PASO02.FD_Id = FLE.folio_detalle_id
		RIGHT JOIN #PASO03 ON #PASO03.LE_Id = FLE.lote_encabezado_id

--Tecnica Rocha
SELECT	#PASO04.FE_FecFolio,
		#PASO04.FD_FechaProd,
		#PASO04.FE_NumFolio,
		#PASO04.FD_NroSec, 
		--MIN(#PASO04.LE_Lote) LOTE, 
		MIN(#PASO04.LD_Pallet) PALET, 
		#PASO04.KgsPro, 
		#PASO04.CjsPro
INTO #FOLSEC
FROM #PASO04
GROUP BY    #PASO04.FE_FecFolio,
			#PASO04.FD_FechaProd,
			#PASO04.FE_NumFolio,
			#PASO04.FD_NroSec, 
			#PASO04.KgsPro, 
			#PASO04.CjsPro
ORDER BY  #PASO04.FD_FechaProd,#PASO04.FE_NumFolio

UPDATE #PASO04 SET #PASO04.CjsPro =0, #PASO04.KgsPro =0 

UPDATE	#PASO04 SET #PASO04.CjsPro = FOLSECU.CjsPro , #PASO04.KgsPro = FOLSECU.KgsPro  
FROM	#PASO04, #FOLSEC FOLSECU
WHERE	#PASO04.FE_FecFolio = FOLSECU.FE_FecFolio
		AND #PASO04.FD_FechaProd = FOLSECU.FD_FechaProd
		AND #PASO04.FE_NumFolio = FOLSECU.FE_NumFolio
		AND #PASO04.FD_NroSec = FOLSECU.FD_NroSec
		--AND #PASO04.LE_Lote = FOLSECU.LOTE
		AND #PASO04.LD_Pallet = FOLSECU.PALET

SELECT	#PASO04.FD_Id
		,#PASO04.DD_Id
		,#PASO04.FE_NumFolio
		,#PASO04.FE_FecFolio
		,#PASO04.FE_Especie
		,#PASO04.FD_NroSec
		,#PASO04.FD_FechaProd
		,#PASO04.KgsPro
		,#PASO04.CjsPro
		,#PASO04.FE_Calibre
		,#PASO04.LE_Id	
		,#PASO04.LD_Id	
		,#PASO04.LE_Lote	
		,#PASO04.LD_Pallet	
		,#PASO04.LD_Calibre	
		,#PASO04.KgsPT	
		,#PASO04.CjsPT
		,#PASO01.*
FROM #PASO01 LEFT JOIN #PASO04 ON #PASO01.DESC_ID = #PASO04.DD_Id
ORDER BY #PASO01.DESC_ID
GO
/****** Object:  StoredProcedure [dbo].[SP_009_descargas_vs_guias_CPN]    Script Date: 29/04/2016 16:46:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Jorge Gatica>
-- Create date: <2015 09 10>
-- Description:	<Extrae descargas y guias de despacho asociadas a cada una de las descargas, procedimiento de agrupar con ceros(0) se hace directo en Excel>
-- =============================================
CREATE PROCEDURE [dbo].[SP_009_descargas_vs_guias_CPN]   
AS
IF OBJECT_ID('tempdb..#PASO01') IS NOT NULL 
	DROP TABLE #PASO01
IF OBJECT_ID('tempdb..#PASO02') IS NOT NULL 
	DROP TABLE #PASO02
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO03
IF OBJECT_ID('tempdb..#PASO03') IS NOT NULL 
	DROP TABLE #PASO04

SELECT
		mareas.id [ID MAREA],
		arte_pesca.nombre [ARTE PESCA],  
		descarga_encabezados.termino_desembarque [FECHA],
		naves.nombre [LANCHA],
		CASE WHEN naves.division_id = 1 THEN 'CM PESCA SUR' ELSE 'CM PESCA NORTE' END  AS [DIVISION],
		descarga_encabezados.codigo_descarga [DI/DA/VALE],
		especies.nombre [ESPECIE],
		descarga_detalles_unidades.cantidad [TOTAL_TON],
		descarga_detalles.zona_pesca [ZONA PESCA],
		v_destinatarios.nombre_razon_social [DESTINO PESCA],
		v_puertos.nombre [PUERTO],
		recintos.nombre [DESCARGA],
		zonas_op.nombre [ZONA OPERACION],
		v_tcs.nombre_razon_social [TCS],
		descarga_detalles.resolucion [RESOLUCION],
		v_armadores.rut + '-' + v_armadores.verificador [RUT_ARM], 
		v_armadores.nombre_razon_social [NOM_ARM_1],
		v_armadores.nombre + ' ' + v_armadores.apellido_paterno + ' ' +	v_armadores.apellido_materno [NOM_ARM_2],
		mareas.fecha_zarpe [FECHA ZARPE],
		recaladas.fecha_recalada [FECHA RECALADA], 
		descarga_encabezados.inicio_desembarque [INIC DESEMBARQUE], 
		tipo_descargas.nombre [TIPO DESCARGA],
		descarga_encabezados.fecha_pesca [FECHA PESCA],   
		descarga_detalles.id DESC_ID
INTO #PASO01
FROM	(RMPCORONELvExplotacion.dbo.descarga_encabezados descarga_encabezados LEFT JOIN RMPCORONELvExplotacion.dbo.descarga_detalles descarga_detalles ON descarga_detalles.descarga_encabezado_id = descarga_encabezados.id)
		LEFT JOIN RMPCORONELvExplotacion.dbo.descarga_detalles_unidades descarga_detalles_unidades ON descarga_detalles_unidades.descarga_detalle_id = descarga_detalles.id,
		RMPCORONELvExplotacion.dbo.recaladas recaladas,
		RMPCORONELvExplotacion.dbo.mareas mareas,
		RMPCORONELvExplotacion.dbo.arte_pesca,
		RMPCORONELvExplotacion.dbo.naves naves,
		RMPCORONELvExplotacion.dbo.especies especies,
		RMPCORONELvExplotacion.dbo.recintos recintos,
		RMPCORONELvExplotacion.dbo.tipo_descargas tipo_descargas,
		RMPCORONELvExplotacion.dbo.v_puertos v_puertos,
		RMPCORONELvExplotacion.dbo.v_tcs v_tcs,
		RMPCORONELvExplotacion.dbo.v_destinatarios,
		RMPCORONELvExplotacion.dbo.zona_operaciones zonas_op,
		RMPCORONELvExplotacion.dbo.v_armadores,
		RMPCORONELvExplotacion.dbo.pontones
WHERE	descarga_detalles.especie_id = especies.id AND
		descarga_detalles.tcs_id = v_tcs.id AND
		descarga_detalles.destinatario_id = v_destinatarios.id AND
		descarga_encabezados.recalada_id = recaladas.id AND
		descarga_encabezados.tipo_descarga_id = tipo_descargas.id AND
		recaladas.ponton_id = recintos.id AND
		recaladas.marea_id = mareas.id AND 
		mareas.nave_id = naves.id AND 
		mareas.arte_pesca_id = arte_pesca.id AND 
		naves.armador_id = v_armadores.id AND
		naves.zona_operacion_id = zonas_op.id AND
		(recaladas.ponton_id = pontones.id AND pontones.puerto_id = v_puertos.id) AND
		descarga_detalles_unidades.unidad_id = 1 
		AND naves.division_id = 2
ORDER BY mareas.id

SELECT	DD.id DESC_ID,
		DE.codigo_descarga [DI/DA/VALE],
		GE.nro_guia [NRO GUIA],
		GE.virtual [GUIA_VIRTUAL],
		GE.fecha_salida [GUIA_FECHA SALIDA], 
		GE.fecha_recepcion [GUIA_FECHA_RECEP],  
		v_pontones.nombre [GUIA_ORIGEN], 
		v_plantas.nombre [GUIA_DESTINO],
		especies.nombre [GUIA_ESPECIE],
		GU.cantidad [TON GUIA],
		CASE WHEN GU.unidad_id = 1 THEN 'TONELADAS' ELSE 'CAJAS' END  AS [UN.MEDIDA GUIA]
INTO #PASO02
FROM	([RMPCORONELvExplotacion].[dbo].[guia_encabezados] GE 
		LEFT JOIN [RMPCORONELvExplotacion].[dbo].[guia_detalles] GD 
			ON GD.guia_encabezado_id = ge.id)
		LEFT JOIN [RMPCORONELvExplotacion].[dbo].[guia_detalles_unidades] GU 
			ON GU.guia_detalle_id = GD.id,
		[RMPCORONELvExplotacion].[dbo].[descarga_detalles] DD,
		[RMPCORONELvExplotacion].[dbo].[descarga_encabezados] DE,
		[RMPCORONELvExplotacion].[dbo].v_pontones v_pontones,
		[RMPCORONELvExplotacion].[dbo].v_plantas v_plantas,
		[RMPCORONELvExplotacion].[dbo].especies especies
WHERE	GD.descarga_detalle_id = DD.id AND
		dd.descarga_encabezado_id = de.id AND
		GD.especie_id = especies.id AND
		GE.origen_id = v_pontones.id AND
		GE.destino_id = v_plantas.id 

SELECT	GDet.descarga_detalle_id [DESC_ID],
		GEnc.nro_guia [NRO GUIA],
		CAMION.patente [PATENTE CAMION],
		CAMION.tipo_camion [TIPO CAMION],
		CAMION.nombre_razon_social [TRANSPORTE],
		CHOFER.nombre [NOMBRE CHOFER]
INTO #PASO04 
FROM	[RMPCORONELvExplotacion].[dbo].[guia_encabezados] GEnc LEFT JOIN [RMPCORONELvExplotacion].[dbo].[guia_detalles] GDet
		ON GEnc.id = GDet.guia_encabezado_id,
		[RMPCORONELvExplotacion].[dbo].v_camiones CAMION,
		[RMPCORONELvExplotacion].[dbo].v_choferes CHOFER
WHERE	GEnc.camion_id = CAMION.id AND
		GEnc.chofer_id = CHOFER.id

SELECT 	#PASO01.[DESC_ID],
		#PASO01.[ID MAREA],
		#PASO01.[ARTE PESCA],
		#PASO01.[FECHA],
		#PASO01.[LANCHA],
		#PASO01.[DIVISION],
		#PASO01.[DI/DA/VALE],
		#PASO01.[ESPECIE],
		#PASO01.[TOTAL_TON],
		#PASO02.[NRO GUIA],
		--#PASO03.[PATENTE CAMION],
		--#PASO03.[TIPO CAMION],
		--#PASO03.TRANSPORTES,
		#PASO02.[GUIA_ESPECIE],
		#PASO02.[TON GUIA],
		#PASO02.[UN.MEDIDA GUIA],
		#PASO01.[ZONA PESCA],
		#PASO01.[DESTINO PESCA],
		#PASO01.[PUERTO],
		#PASO01.[DESCARGA],
		#PASO01.[ZONA OPERACION],
		#PASO01.[TCS],
		#PASO01.[RESOLUCION],
		#PASO01.[RUT_ARM], 
		#PASO01.[NOM_ARM_1],
		#PASO01.[NOM_ARM_2],
		--#PASO01.[PUERTO],
		#PASO01.[FECHA ZARPE],
		#PASO01.[FECHA RECALADA], 
		#PASO01.[INIC DESEMBARQUE], 
		#PASO01.[TIPO DESCARGA],
		#PASO01.[FECHA PESCA],   
		#PASO02.[GUIA_VIRTUAL],
		#PASO02.[GUIA_FECHA SALIDA], 
		#PASO02.[GUIA_FECHA_RECEP],  
		#PASO02.[GUIA_ORIGEN], 
		#PASO02.[GUIA_DESTINO]
INTO #PASO03	 
FROM (#PASO01 LEFT JOIN #PASO02 ON #PASO01.DESC_ID = #PASO02.DESC_ID)
	  --LEFT JOIN #PASO03 ON #PASO02.[NRO GUIA] = #PASO03.[NRO GUIA]
ORDER BY #PASO01.[DESC_ID]

SELECT	#PASO03.[DESC_ID],
		#PASO03.[ID MAREA],
		#PASO03.[ARTE PESCA],
		#PASO03.[FECHA],
		#PASO03.[LANCHA],
		#PASO03.[DIVISION],
		#PASO03.[DI/DA/VALE],
		#PASO03.[ESPECIE],
		#PASO03.[TOTAL_TON],
		#PASO03.[UN.MEDIDA GUIA],
		#PASO03.[NRO GUIA],
		#PASO04.[PATENTE CAMION],
		#PASO04.[TIPO CAMION],
		#PASO04.[TRANSPORTE],
		#PASO04.[NOMBRE CHOFER],
		#PASO03.[GUIA_ESPECIE],
		#PASO03.[TON GUIA],
		#PASO03.[ZONA PESCA],
		#PASO03.[DESTINO PESCA],
		#PASO03.[PUERTO],
		#PASO03.[DESCARGA],
		#PASO03.[ZONA OPERACION],
		#PASO03.[TCS],
		#PASO03.[RESOLUCION],
		#PASO03.[RUT_ARM], 
		#PASO03.[NOM_ARM_1],
		#PASO03.[NOM_ARM_2],
		#PASO03.[FECHA ZARPE],
		#PASO03.[FECHA RECALADA], 
		#PASO03.[INIC DESEMBARQUE], 
		#PASO03.[TIPO DESCARGA],
		#PASO03.[FECHA PESCA],   
		#PASO03.[GUIA_VIRTUAL],
		#PASO03.[GUIA_FECHA SALIDA], 
		#PASO03.[GUIA_FECHA_RECEP],  
		#PASO03.[GUIA_ORIGEN], 
		#PASO03.[GUIA_DESTINO]
FROM #PASO03 LEFT JOIN #PASO04 
		ON #PASO03.[DESC_ID] = #PASO04.[DESC_ID] AND 
			#PASO03.[NRO GUIA] = #PASO04.[NRO GUIA]
ORDER BY #PASO03.[DESC_ID]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[12] 4[25] 2[45] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'descargas_disponibles'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'descargas_disponibles'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[17] 4[3] 2[63] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = -288
         Left = 0
      End
      Begin Tables = 
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'descargas_disponibles_folios'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'descargas_disponibles_folios'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = -288
         Left = 0
      End
      Begin Tables = 
         Begin Table = "GuiaEncabezados"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'guias_sin_calidad'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'guias_sin_calidad'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "auxiliares"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_armadores'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_armadores'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "camiones"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "auxiliares"
            Begin Extent = 
               Top = 6
               Left = 274
               Bottom = 126
               Right = 472
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_camiones'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_camiones'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "auxiliares"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_choferes'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_choferes'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "auxiliares"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_destinatarios'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_destinatarios'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "recintos"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "plantas"
            Begin Extent = 
               Top = 6
               Left = 274
               Bottom = 111
               Right = 472
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_plantas'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_plantas'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "pontones"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 96
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "recintos"
            Begin Extent = 
               Top = 6
               Left = 274
               Bottom = 126
               Right = 472
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_pontones'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_pontones'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "puertos"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 81
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
         Begin Table = "recintos"
            Begin Extent = 
               Top = 6
               Left = 274
               Bottom = 126
               Right = 472
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_puertos'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_puertos'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[40] 4[20] 2[20] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "auxiliares"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 126
               Right = 236
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 15
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
         Or = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_tcs'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_tcs'
GO
USE [master]
GO
ALTER DATABASE [RMPCORONELv2] SET  READ_WRITE 
GO
