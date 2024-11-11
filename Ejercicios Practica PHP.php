<?php
$alumnos = [];

function agregarAlumno(&$alumnos) {
    $nombre = readline("Nombre del alumno: ");
    
    $edad = intval(readline("Edad del alumno: "));
    if ($edad < 0) {
        echo "Error: La edad no puede ser negativa.\n";
        return;
    }
    
    $nota = floatval(readline("Nota del alumno: "));
    if ($nota < 0 || $nota > 10) {
        echo "Error: La nota debe estar entre 0 y 10.\n";
        return;
    }
    
    $asistencias = floatval(readline("Asistencias del alumno (en porcentaje): "));
    
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
            $edad = intval(readline("Nueva edad (actual: {$alumno['edad']}): "));
            if ($edad >= 0) {
                $alumno['edad'] = $edad;
            } else {
                echo "Edad inválida.\n";
            }

            $nota = floatval(readline("Nueva nota (actual: {$alumno['nota']}): "));
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

// Función para buscar alumnos por rango de edad
function buscarAlumnosPorRangoEdad($alumnos, $edadMin, $edadMax) {
    foreach ($alumnos as $alumno) {
        if ($alumno['edad'] >= $edadMin && $alumno['edad'] <= $edadMax) {
            echo "Nombre: {$alumno['nombre']}, Edad: {$alumno['edad']}\n";
        }
    }
}

do {
    echo "\nMenu:\n1. Agregar Alumno\n2. Mostrar Alumnos\n3. Buscar Alumno\n4. Eliminar Alumno\n5. Actualizar Alumno\n6. Estadísticas de Notas\n7. Mayor y Menor Edad\n8. Mediana de Notas\n9. Buscar por Rango de Edad\n0. Salir\n";
    $opcion = intval(readline("Seleccione una opción: "));

    switch ($opcion) {
        case 1:
            agregarAlumno($alumnos);
            break;
        case 2:
            mostrarAlumnos($alumnos);
            break;
        case 3:
            $nombreBuscado = readline("Nombre del alumno a buscar: ");
            buscarAlumno($alumnos, $nombreBuscado);
            break;
        case 4:
            $nombreBuscado = readline("Nombre del alumno a eliminar: ");
            eliminarAlumno($alumnos, $nombreBuscado);
            break;
        case 5:
            $nombreBuscado = readline("Nombre del alumno a actualizar: ");
            actualizarAlumno($alumnos, $nombreBuscado);
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
            $edadMin = intval(readline("Edad mínima: "));
            $edadMax = intval(readline("Edad máxima: "));
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
