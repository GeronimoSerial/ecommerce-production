---
trigger: always_on
---

Arquitectura y Estructura
Usar siempre el patrón Modelo-Vista-Controlador (MVC):
Todo el código debe organizarse bajo este patrón para mantener claridad y separación de responsabilidades.

Evitar lógica en las vistas:
La vista solo debe mostrar datos. La lógica va en el controlador o modelo.

No usar this ni clases en JavaScript:
Evitá por completo el uso de clases y this en JavaScript. Preferí funciones puras, closures y programación funcional.

Base de datos
No cambiar nombres de campos existentes:
Reutilizá los nombres actuales. No rompas migraciones, consultas existentes ni integraciones.

Seguir convenciones consistentes:
Usar snake_case en campos de base de datos. No inventar nuevos estilos.

Código limpio
Código claro y legible ante todo:
Nombres descriptivos, sin abreviaciones confusas. Si el código no se entiende al leerlo una vez, está mal.

Comentar solo cuando es necesario:
El código debe explicarse solo. Comentá funciones complejas o decisiones no obvias.

Centralizar constantes y configuraciones:
Nada de valores mágicos o duplicados por todo el código. Usar archivos de configuración.

Validar datos en el backend (además del frontend):
Nunca confiar únicamente en la validación del lado del cliente.

Buenas prácticas de desarrollo
Usar control de versiones de forma responsable:
Commits atómicos, claros y con mensajes que expliquen el por qué, no el qué. Usar ramas para features y fixes.

Revisar el código antes de subir:
No subir cambios sin revisar. Asegurate de no dejar console.log, comentarios innecesarios ni código muerto.
