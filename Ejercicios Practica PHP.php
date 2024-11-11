<?php
$alumnos = [];
$totalNotas = 0;
$aprobados = 0;
$suspendidos = 0;


function validarEdad($edad) {
    return ($edad > 0 && $edad <= 120);  
}

function validarNota($nota) {
    return ($nota >= 0 && $nota <= 10);
}

function buscarAlumno($nombre, $alumnos) {
    foreach ($alumnos as $alumno) {
        if (strtolower($alumno['nombre']) == strtolower($nombre)) {
            return $alumno;
        }
    }
    return null;
}

function eliminarAlumno(&$alumnos, $nombre) {
    foreach ($alumnos as $indice => $alumno) {
        if (strtolower($alumno['nombre']) == strtolower($nombre)) {
            unset($alumnos[$indice]);
            echo "Alumno eliminado con éxito.\n";
            return;
        }
    }
    echo "Alumno no encontrado.\n";
}

function mostrarAlumno($alumno) {
    if ($alumno) {
        echo "Nombre: {$alumno['nombre']}, Edad: {$alumno['edad']}, Nota: {$alumno['nota']}\n";
    } else {
        echo "Alumno no encontrado.\n";
    }
}

while ($nombre!='salir') {
    $nombre = readline("Introduce el nombre del alumno (o 'salir' para terminar): ");

    $edad = readline("Introduce la edad de $nombre: ");
    $nota = floatval(readline("Introduce la nota de $nombre: "));

    $alumnos[] = ['nombre' => $nombre, 'edad' => $edad, 'nota' => $nota];
    $totalNotas += $nota;

    if ($nota >= 5) {
        $aprobados++;
    } else {
        $suspendidos++;
    }

}
?>
