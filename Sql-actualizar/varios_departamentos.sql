--PhpMyAdmin
ALTER TABLE `config` CHANGE `centro` `centro` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


--SqlServer

USE [Poner_Nombre_de_la_base_de_datos]
GO
/****** Object:  StoredProcedure [dbo].[roldehorarioEmp]    Script Date: 11/04/2018 10:22:56 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER proc [dbo].[roldehorarioEmp]

@empresa as VARCHAR(8),
@CENTRO as VARCHAR(12),
@Tp as VARCHAR(2)

as

DECLARE @long as varchar(10)
IF (SELECT charindex(' ', mascara) FROM empresas WHERE empresa =@empresa) = 0
	set @long = 0;
ELSE      
	set @long = (SELECT LEN (LEFT (mascara, charindex(' ', mascara) -1)) AS mascara FROM empresas WHERE empresa = @empresa);

DECLARE @cols AS NVARCHAR(MAX), @query  AS NVARCHAR(MAX)
    select @cols = STUFF((SELECT ',' + QUOTENAME(convert(VARCHAR(10), nombre_dia, 120))

                        from detalle_horarios as x
                        
                        WHERE  x.empresa = @empresa
                        group by nombre_dia,
                                 dia_Semana  
                        order by dia_Semana 
                FOR XML PATH(''), TYPE
                ).value('.', 'NVARCHAR(MAX)') 
            ,1,1,'')

    set @query = CASE WHEN @Tp = '1' 
    THEN 
    'select codigo,nomE, Horario, Nombre,' + @cols + ' from
                    ( select a.codigo, a.ap_paterno+'' ''+a.ap_materno+'' ''+a.nombre AS nomE, l.horario,
                      k.nombre,
                      x.nombre_dia,
                      (case when entra1 = '''' then ''DESCANSO'' else x.entra1 +'' A ''+ x.sale1 end) AS Hora                                                  
     from empleados as a 
	 inner join Llaves as l on l.codigo = a.codigo
	 inner join horarios_catalogo as k on k.horario = l.horario 
	 inner join detalle_horarios as x on x.horario = k.horario and l.empresa = k.empresa
	 
    
                
    where  l.centro IN ('+@CENTRO+') and l.empresa = '+@empresa+' and a.activo= ''S''

                 ) x
                pivot 
                (
                    min(Hora)
                    for nombre_dia in (' + @cols + ')                    
                )q ORDER BY nomE'
    ELSE 
    
    'select codigo,nomE, Horario, Nombre,' + @cols + ' from
                    ( select a.codigo, a.ap_paterno+'' ''+a.ap_materno+'' ''+a.nombre AS nomE, l.horario,
                      k.nombre,
                      x.nombre_dia,
                      (case when entra1 = '''' then ''DESCANSO'' else x.entra1 +'' A ''+ x.sale1 end) AS Hora                                                  
     from empleados as a 
	 inner join Llaves as l on l.codigo = a.codigo
	 inner join horarios_catalogo as k on k.horario = l.horario 
	 inner join detalle_horarios as x on x.horario = k.horario and l.empresa = k.empresa
	 
    
                
    where  l.centro IN ('+@CENTRO+') and l.empresa = '+@empresa+' and a.activo= ''S''

                 ) x
                pivot 
                (
                    min(Hora)
                    for nombre_dia in (' + @cols + ')                    
                )q ORDER BY nomE'
    
    END

    execute(@query);

    -----------------------------------------------------OTRO
    USE [NUEVA_EMPRESA]
GO
/****** Object:  StoredProcedure [dbo].[proc_retardos]    Script Date: 11/04/2018 10:50:25 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Batch submitted through debugger: SQLQuery1.sql|7|0|C:\Users\Administrador\AppData\Local\Temp\1\~vsBEC5.sql

ALTER proc [dbo].[proc_retardos]

@fecha1 AS VARCHAR(10), 
@fecha2 AS VARCHAR(10), 
@CENTRO AS VARCHAR(12), 
@superv AS VARCHAR(8), 
@empresa AS VARCHAR(8), 
@tiponom AS VARCHAR(1),
@EoS AS VARCHAR(1),
@minOmax AS VARCHAR(4), /*min cuando es E, max cuando es S*/
@Tp AS VARCHAR(2)

AS

DECLARE @long as varchar(10)
IF (SELECT charindex(' ', mascara) FROM empresas WHERE empresa =@empresa) = 0
	set @long = 0;
ELSE      
	set @long = (SELECT LEN (LEFT (mascara, charindex(' ', mascara) -1)) AS mascara FROM empresas WHERE empresa = @empresa);

DECLARE @cols AS NVARCHAR(MAX), 

@query AS NVARCHAR(MAX) 

DECLARE @date DateTime

SET @cols = ''
SET @date = @fecha1

WHILE @date <= @fecha2
BEGIN
    if @date = @fecha2
		SET @cols = @cols + '[' + CONVERT(VARCHAR(10), @date, 103)
		+ '] ';
	else 
		SET @cols = @cols + '[' + CONVERT(VARCHAR(10), @date, 103)
		+ '],';		
    SET @date = @date + 1
END

set @query = CASE WHEN @Tp = '1'
THEN 
 'SELECT codigo, Nombre, sueldo, '''+ @EoS +''' Tpo, ' + @cols + ' 
			from ( SELECT empleados.codigo, ap_paterno+'' ''+ap_materno+'' ''+nombre AS Nombre,
			empleados.sueldo, Tabulador.Actividad, 
			convert(VARCHAR(10), relch_registro.fecha, 103) fecha, 
			relch_registro.tiempo 
			FROM Empleados 
			INNER JOIN Llaves ON Llaves.Codigo = Empleados.Codigo AND Llaves.Empresa = Empleados.Empresa
			INNER JOIN relch_registro on relch_registro.codigo = Empleados.Codigo 
			INNER JOIN Tabulador ON Tabulador.Ocupacion = Llaves.Ocupacion AND Tabulador.Empresa = Llaves.Empresa 
			WHERE Empleados.Activo = ''S'' and 
			relch_registro.centro IN ('+@CENTRO+') 
			and empleados.empresa = '+@empresa+' 
			and relch_registro.tiponom = '+@tiponom+' 
			and relch_registro.fecha BETWEEN ' + QUOTENAME(@fecha1,'''') + ' AND ' + QUOTENAME(@fecha2,'''') + ' 
			and relch_registro.checada<>''00:00:00'' and num_conc = 120 
			) x pivot 
				( '+@MinOMax+'(tiempo) for fecha in (' + @cols + ') 
			) p 
			ORDER BY Codigo, Tpo' 
ELSE 

 'SELECT codigo, Nombre, sueldo, '''+ @EoS +''' Tpo, ' + @cols + ' 
			from ( SELECT empleados.codigo, ap_paterno+'' ''+ap_materno+'' ''+nombre AS Nombre,
			empleados.sueldo, Tabulador.Actividad, 
			convert(VARCHAR(10), relch_registro.fecha, 103) fecha, 
			relch_registro.tiempo 
			FROM Empleados 
			INNER JOIN Llaves ON Llaves.Codigo = Empleados.Codigo AND Llaves.Empresa = Empleados.Empresa
			INNER JOIN relch_registro on relch_registro.codigo = Empleados.Codigo 
			INNER JOIN Tabulador ON Tabulador.Ocupacion = Llaves.Ocupacion AND Tabulador.Empresa = Llaves.Empresa 
			WHERE Empleados.Activo = ''S'' and 
			relch_registro.centro IN ('+@CENTRO+') 
			and empleados.empresa = '+@empresa+' 
			and relch_registro.tiponom = '+@tiponom+' 
			and relch_registro.fecha BETWEEN ' + QUOTENAME(@fecha1,'''') + ' AND ' + QUOTENAME(@fecha2,'''') + ' 
			and relch_registro.checada<>''00:00:00'' and num_conc = 120 
			) x pivot 
				( '+@MinOMax+'(tiempo) for fecha in (' + @cols + ') 
			) p 
			ORDER BY Codigo, Tpo' 

END
	execute(@query) 