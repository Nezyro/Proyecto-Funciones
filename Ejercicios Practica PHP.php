<?php

$alumnos = [];

function agregarAlumno(&$alumnos) {
    echo "Nombre del alumno: ";
    $nombre = trim(fgets(STDIN));
    
    echo "Edad del alumno: ";
    $edad = intval(fgets(STDIN));
    if ($edad < 0) {
        echo "Error: La edad no puede ser negativa.\n";
        return;
    }
    
    echo "Nota del alumno: ";
    $nota = floatval(fgets(STDIN));
    if ($nota < 0 || $nota > 10) {
        echo "Error: La nota debe estar entre 0 y 10.\n";
        return;
    }
    
    echo "Asistencias del alumno (en porcentaje): ";
    $asistencias = floatval(fgets(STDIN));
    
    $alumno = [
        "nombre" => $nombre,
        "edad" => $edad,
        "nota" => $nota,
        "asistencias" => $asistencias
    ];
    array_push($alumnos, $alumno);
    echo "Alumno agregado correctamente.\n";
}

function mostrarAlumnos($alumnos) {
    usort($alumnos, fn($a, $b) => strcmp($a['nombre'], $b['nombre'])); // Ordena por nombre alfabéticamente
    foreach ($alumnos as $alumno) {
        echo "Nombre: {$alumno['nombre']}, Edad: {$alumno['edad']}, Nota: {$alumno['nota']}, Asistencias: {$alumno['asistencias']}%\n";
    }
}

function buscarAlumno($alumnos, $nombreBuscado) {
    foreach ($alumnos as $alumno) {
        if (strtolower($alumno['nombre']) == strtolower($nombreBuscado)) {
            echo "Nombre: {$alumno['nombre']}, Edad: {$alumno['edad']}, Nota: {$alumno['nota']}, Asistencias: {$alumno['asistencias']}%\n";
            return;
        }
    }
    echo "Alumno no encontrado.\n";
}

function eliminarAlumno(&$alumnos, $nombreBuscado) {
    foreach ($alumnos as $index => $alumno) {
        if (strtolower($alumno['nombre']) == strtolower($nombreBuscado)) {
            unset($alumnos[$index]);
            echo "Alumno eliminado correctamente.\n";
            return;
        }
    }
    echo "Alumno no encontrado.\n";
}

function actualizarAlumno(&$alumnos, $nombreBuscado) {
    foreach ($alumnos as &$alumno) {
        if (strtolower($alumno['nombre']) == strtolower($nombreBuscado)) {
            echo "Nueva edad (actual: {$alumno['edad']}): ";
            $edad = intval(fgets(STDIN));
            if ($edad >= 0) {
                $alumno['edad'] = $edad;
            } else {
                echo "Edad inválida.\n";
            }

            echo "Nueva nota (actual: {$alumno['nota']}): ";
            $nota = floatval(fgets(STDIN));
            if ($nota >= 0 && $nota <= 10) {
                $alumno['nota'] = $nota;
            } else {
                echo "Nota inválida.\n";
            }
            echo "Datos actualizados.\n";
            return;
        }
    }
    echo "Alumno no encontrado.\n";
}

function calcularEstadisticasNotas($alumnos) {
    $totalNotas = 0;
    $cantidadAprobados = 0;
    $cantidadSuspendidos = 0;

    foreach ($alumnos as $alumno) {
        $totalNotas += $alumno['nota'];
        if ($alumno['nota'] >= 5) {
            $cantidadAprobados++;
        } else {
            $cantidadSuspendidos++;
        }
    }

    $promedio = $totalNotas / count($alumnos);
    echo "Promedio de notas: $promedio\n";
    echo "Cantidad de aprobados: $cantidadAprobados\n";
    echo "Cantidad de suspendidos: $cantidadSuspendidos\n";
}

function mostrarMayorMenorEdad($alumnos) {
    if (empty($alumnos)) return;

    $mayor = $alumnos[0];
    $menor = $alumnos[0];

    foreach ($alumnos as $alumno) {
        if ($alumno['edad'] > $mayor['edad']) $mayor = $alumno;
        if ($alumno['edad'] < $menor['edad']) $menor = $alumno;
    }

    echo "Alumno de mayor edad: {$mayor['nombre']} ({$mayor['edad']} años)\n";
    echo "Alumno de menor edad: {$menor['nombre']} ({$menor['edad']} años)\n";
}

function calcularMedianaNotas($alumnos) {
    $notas = array_column($alumnos, 'nota');
    sort($notas);
    $count = count($notas);
    $mediana = ($count % 2 == 0) ? ($notas[$count / 2 - 1] + $notas[$count / 2]) / 2 : $notas[floor($count / 2)];
    echo "Mediana de las notas: $mediana\n";
}

function buscarAlumnosPorRangoEdad($alumnos, $edadMin, $edadMax) {
    foreach ($alumnos as $alumno) {
        if ($alumno['edad'] >= $edadMin && $alumno['edad'] <= $edadMax) {
            echo "Nombre: {$alumno['nombre']}, Edad: {$alumno['edad']}\n";
        }
    }
}
ç
do {
    echo "\nMenu:\n1. Agregar Alumno\n2. Mostrar Alumnos\n3. Buscar Alumno\n4. Eliminar Alumno\n5. Actualizar Alumno\n6. Estadísticas de Notas\n7. Mayor y Menor Edad\n8. Mediana de Notas\n9. Buscar por Rango de Edad\n0. Salir\n";
    echo "Seleccione una opción: ";
    $opcion = intval(fgets(STDIN));

    switch ($opcion) {
        case 1:
            agregarAlumno($alumnos);
            break;
        case 2:
            mostrarAlumnos($alumnos);
            break;
        case 3:
            echo "Nombre del alumno a buscar: ";
            buscarAlumno($alumnos, trim(fgets(STDIN)));
            break;
        case 4:
            echo "Nombre del alumno a eliminar: ";
            eliminarAlumno($alumnos, trim(fgets(STDIN)));
            break;
        case 5:
            echo "Nombre del alumno a actualizar: ";
            actualizarAlumno($alumnos, trim(fgets(STDIN)));
            break;
        case 6:
            calcularEstadisticasNotas($alumnos);
            break;
        case 7:
            mostrarMayorMenorEdad($alumnos);
            break;
        case 8:
            calcularMedianaNotas($alumnos);
            break;
        case 9:
            echo "Edad mínima: ";
            $edadMin = intval(fgets(STDIN));
            echo "Edad máxima: ";
            $edadMax = intval(fgets(STDIN));
            buscarAlumnosPorRangoEdad($alumnos, $edadMin, $edadMax);
            break;
        case 0:
            echo "Saliendo del programa...\n";
            break;
        default:
            echo "Opción no válida.\n";
            break;
    }
} while ($opcion != 0);

?>
