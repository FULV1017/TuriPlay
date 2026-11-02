---
name: TuriPlay
description: Landing turística con fotografía peruana, ámbar y verde profundo.
colors:
  forest: "#142c28"
  amber: "#f5b544"
  paper: "#f8faf7"
  muted: "#52635d"
  amber-hover: "#ffca6c"
  forest-hover: "#2a4d43"
  focus: "#ca7800"
  error: "#9c2929"
  brand-dot: "#bc7400"
  link-hover: "#946000"
  white: "#fff"
  hero-copy: "#f0f4ef"
  sage-title: "#597164"
  feature-surface: "#eaf0e8"
  feature-border: "#b8c8ba"
  link-border: "#96a59a"
  privacy-copy: "#42594a"
  step-border: "#d4dfd3"
  step-copy: "#7b570f"
  step-surface: "#f6e6c5"
  closing-copy: "#4d3b19"
  footer-copy: "#eff5ec"
  footer-muted: "#c0d0c4"
  panel-canvas: "#f2f5f1"
  panel-surface: "#ffffff"
  panel-ink: "#193b32"
  panel-muted: "#576b61"
  panel-border: "#dce5dd"
  panel-soft: "#f6f8f5"
  panel-dark-canvas: "#101b18"
  panel-dark-surface: "#182620"
  panel-dark-ink: "#edf4ed"
  panel-dark-muted: "#b3c6b9"
  panel-dark-border: "#34473c"
  panel-dark-soft: "#1e3027"
typography:
  display:
    fontFamily: "'Barlow Condensed', sans-serif"
    fontSize: "clamp(4rem, 7vw, 6rem)"
    fontWeight: 600
    lineHeight: 1.02
    letterSpacing: "-.015em"
  headline:
    fontFamily: "'Barlow Condensed', sans-serif"
    fontSize: "clamp(2.7rem, 4.3vw, 4.6rem)"
    fontWeight: 600
    lineHeight: 1.02
    letterSpacing: "-.015em"
  title:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 650
    lineHeight: 1.3
  body:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "16px"
    lineHeight: 1.65
  label:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: ".85rem"
    fontWeight: 600
  button:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: ".95rem"
    fontWeight: 700
    lineHeight: 1.4
  brand:
    fontFamily: "'Instrument Sans', ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.85rem"
    fontWeight: 800
    lineHeight: 1
    letterSpacing: "-.06em"
rounded:
  button: "5px"
  brand-symbol: "9px"
  step-number: "50%"
spacing:
  copy-gap: "18px"
  row-gap: "22px"
  control-gap: "24px"
  group-gap: "30px"
  button-gap: "35px"
  section-desktop: "100px"
  section-tablet: "75px"
  section-mobile: "60px"
components:
  button-primary:
    backgroundColor: "{colors.amber}"
    textColor: "{colors.forest}"
    typography: "{typography.button}"
    rounded: "{rounded.button}"
    padding: "14px 24px"
  button-primary-hover:
    backgroundColor: "{colors.amber-hover}"
  button-small:
    backgroundColor: "{colors.amber}"
    textColor: "{colors.forest}"
    rounded: "{rounded.button}"
    padding: "11px 17px"
  button-dark:
    backgroundColor: "{colors.forest}"
    textColor: "{colors.white}"
    typography: "{typography.button}"
    rounded: "{rounded.button}"
    padding: "14px 24px"
  button-dark-hover:
    backgroundColor: "{colors.forest-hover}"
  text-link:
    textColor: "{colors.forest}"
    padding: "4px 0"
  feature-item:
    textColor: "{colors.forest}"
    padding: "34px 35px 35px 0"
  step-number:
    backgroundColor: "{colors.step-surface}"
    textColor: "{colors.step-copy}"
    rounded: "{rounded.step-number}"
    width: "35px"
    height: "35px"
---

# Design System: TuriPlay

## Overview

La identidad implementada combina fotografía de Machu Picchu, titulares condensados, superficies claras y acento ámbar sobre verde profundo. La fotografía ocupa el hero; el resto de la página utiliza bandas planas, líneas divisorias y espacio generoso, sin tarjetas flotantes ni sombras.

Este documento registra la landing y su ampliación pública de videos, además de una extensión independiente del panel Filament. La jerarquía inicial priorizaba crear una cuenta; Explorar permite ahora ver videos elegidos por sus dueños sin registrarse. No se añade una metáfora de marca nueva: la dirección documentada es fotografía Perú / ámbar / verde profundo.

**Key Characteristics:**
- Fotografía peruana real con veladuras oscuras para sostener el texto.
- Barlow Condensed para titulares; Instrument Sans declarada para cuerpo e interfaz.
- Ámbar para registro y énfasis; verde profundo para estructura y contraste.
- Componentes planos, divisores finos y adaptación móvil a una columna.

Evidencia: `resources/views/landing.blade.php`, `resources/css/landing.css`, `resources/css/app.css`, `PRODUCT.md` y capturas `.impeccable/review/desktop.png` y `mobile.png`. Los valores normativos están en el frontmatter; los detalles que su esquema no admite están en `.impeccable/design.json`. Las rampas OKLCH del sidecar son muestras sintéticas para el panel de documentación, no tokens usados por la landing. `northStar` queda vacío porque no se aprobó una metáfora de marca adicional; los snippets usan anclas locales de demostración y no ejecutan el registro.

## Colors

### Primary
- **Ámbar de acción (`amber`)**: botones de registro, palabra destacada del hero, símbolo de reproducción y banda de cierre. Su variante `amber-hover` responde al puntero.
- **Verde profundo (`forest`)**: texto principal, fondo del hero antes de cargar la imagen, pie y botón invertido del cierre. `forest-hover` corresponde a ese botón.

### Secondary
- **Salvia (`sage-title`, `feature-surface`)**: segunda línea del título introductorio y banda de funcionalidades.
- **Ámbar suave (`step-surface`, `step-copy`)**: numeración circular de los pasos.

### Neutral
- **Papel (`paper`)**: fondo general y cabecera.
- **Texto secundario (`muted`)**: párrafos explicativos; `privacy-copy` matiza el aviso de privacidad.
- **Divisores (`feature-border`, `step-border`, `link-border`)**: columnas de funcionalidades, pasos y enlace editorial, respectivamente.
- **Texto sobre fondos oscuros (`white`, `hero-copy`, `footer-copy`, `footer-muted`)**: títulos, descripción del hero y pie.
- **Detalles cálidos (`brand-dot`, `link-hover`, `closing-copy`)**: punto del logotipo claro, enlaces al pasar el puntero y descripción del cierre.
- **Foco (`focus`)**: contorno visible de teclado, no una segunda acción primaria.

Las veladuras del hero usan `rgba(8,28,24,…)`; son capas de imagen, no superficies nuevas de la interfaz. La selección de texto utiliza ámbar con texto verde profundo.

## Typography

**Display Font:** Barlow Condensed, fallback sans-serif. La landing carga el archivo local `resources/fonts/barlow-condensed-semibold.ttf`, peso 600 y `font-display: swap`, con preload en Blade.

**Body Font:** Instrument Sans, seguida de ui-sans-serif, system-ui y sans-serif. Se declara tanto en el cuerpo de la landing como en el tema de `app.css`. Los archivos inspeccionados no incluyen un `@font-face` o import de Instrument Sans: documentar la pila no garantiza que esa fuente esté descargada; el navegador puede usar el fallback. No hay tipografía monoespaciada.

### Hierarchy
- **Display**: h1 con la definición `display`; la palabra final se colorea ámbar. En móvil cambia a `clamp(3.6rem,13vw,5rem)`.
- **Headline**: h2 con la definición `headline`. El cierre usa `clamp(2.7rem,4vw,4.1rem)`; en móvil la introducción usa `3.2rem` y el cierre `2.9rem`. Los h1/h2 equilibran líneas mediante `text-wrap: balance`.
- **Title**: h3 de funcionalidades y pasos, según `title`.
- **Body**: texto base según `body`. La descripción del hero usa `1.08rem`, interlínea `1.75`, ancho máximo `470px`; en móvil `0.97rem` y `32ch`. Las descripciones de funcionalidades y pasos usan `0.92rem`; las primeras limitan la medida a `30ch`, ampliada a `37ch` en móvil.
- **Label**: navegación y enlace auxiliar del hero; botones según `button`. No hay transformación general a mayúsculas.
- **Brand**: logotipo tipográfico según `brand`, reducido a `1.5rem` en móvil.

## Layout

La cabecera es flex, no fija, con ancho máximo `1600px`, altura mínima `98px` y padding `18px 5%`. Las secciones centrales tienen ancho máximo `1440px`, margen automático y padding `100px 8%`. Las anclas de sección tienen `scroll-margin-top:30px`.

El hero es de ancho completo, con contenido hasta `1100px`, padding `75px 8% 110px` y min-height efectivo `min(790px,calc(100svh - 98px))` en navegadores compatibles; `660px` es el fallback previo. La foto usa `object-fit:cover` y posición `center 53%`. La franja inferior sitúa una frase a la izquierda y ubicación a la derecha.

La introducción tiene dos columnas `1.1fr 1fr`, separación `80px` y texto hasta `540px`. Las funcionalidades usan banda salvia sin límite exterior, con cabecera y lista hasta `1210px`; la lista tiene tres columnas iguales. El bloque de pasos usa dos columnas iguales separadas por `100px`. El cierre y pie son filas flex con extremos separados.

### Responsive observado en CSS
- **Hasta 1000px inclusive**: se oculta la navegación de anclas sin reemplazo por menú hamburguesa; permanecen marca, inicio de sesión y registro. Hero mínimo `650px`; secciones `75px 6%`, separación de introducción `40px` y de pasos `55px`. Funcionalidades conservan tres columnas con padding lateral reducido a `20px`; cierre `55px 6%`.
- **Hasta 640px inclusive**: cabecera mínima `80px`, padding `17px 5%`; registro compacto mínimo `40px`, padding `10px 12px`, sin flecha, con fuente `0.72rem`. Inicio de sesión también `0.72rem`. Hero mínimo `calc(100svh - 80px)` con fallback `660px` y máximo `850px`; contenido `70px 6% 120px`; foto `61% center` y veladura móvil propia. Enlace auxiliar debajo del CTA; se oculta la frase inferior y permanece la ubicación a la derecha.
- **Hasta 640px, contenido**: secciones `60px 6%`; introducción y pasos pasan a una columna con gap `30px`. Funcionalidades pasan a una columna, con icono a la izquierda, padding `26px 0`, gap `22px`, sin divisores verticales y con líneas entre filas. Cierre apilado con padding `50px 6%`; CTA separado `28px`. Pie permite wrap, con lema en una fila completa al final.
- **Desde 1600px inclusive**: el padding izquierdo del hero pasa a `max(8%,calc((100vw - 1344px)/2))`.

Estas reglas son las implementadas, no una promesa de nuevos breakpoints o dispositivos.

## Elevation & Depth

No se declara `box-shadow`. La profundidad proviene de la imagen, sus dos gradientes y el contraste entre bandas. En escritorio la veladura horizontal utiliza opacidades `.83`, `.42` al `52%` y `.08`; la inferior `.6` a transparente al `35%`. En móvil, la horizontal usa `.76` y `.24`, y la inferior `.65` a transparente al `45%`.

La imagen entra de escala `1.045` a `1` durante `1.3s`, con curva `cubic-bezier(.16,1,.3,1)` y relleno `both`. Los enlaces transicionan fondo y color durante `.2s` (ease implícito CSS). `prefers-reduced-motion:reduce` elimina animaciones y transiciones y fuerza scroll automático. No hay parallax ni movimiento ligado al scroll.

## Shapes

Botones rectangulares con esquinas suavizadas según `rounded.button`. El símbolo de marca usa `rounded.brand-symbol`; la numeración de pasos es circular según `rounded.step-number`. Las bandas de contenido no tienen borde redondeado. Los límites de funcionalidades y pasos son líneas de `1px`, no tarjetas independientes. Los SVG son de trazo redondeado, grosor `1.6`, normalmente `24px`; las funcionalidades usan `32px` y el pin de ubicación `17px`.

## Components

### Buttons

El CTA principal es un enlace semántico a registro, con ámbar, texto verde, alto mínimo `56px`, gap `35px`, flecha ascendente y tokens `button-primary`. El compacto de cabecera usa mínimo `44px`, gap `20px`, fuente `0.8rem` y tokens `button-small`; aplica las reducciones móviles de Layout. El cierre invierte a verde con texto blanco (`button-dark`), manteniendo medidas del principal. Los hover utilizan sus variantes documentadas; no hay estado active o disabled específico.

Todos los enlaces reciben foco visible de `3px solid` en el color `focus`, separado `6px`. El acceso de salto al contenido aparece al enfocar: posición fija, izquierda `20px`, top `10px`, fondo blanco, padding `12px`, z-index `20`; fuera de foco está en top `-100px`.

### Navigation

La marca enlaza al inicio. La cabecera contiene anclas «Qué es TuriPlay» y «Cómo funciona», con fuente label y gap `30px`; inicio de sesión es enlace de texto y registro un botón compacto. Los enlaces de navegación e inicio responden con `link-hover`. No hay estado de sección activa, sticky header o menú desplegable. El pie repite marca, lema e inicio de sesión; su hover de acceso es ámbar.

### Editorial links

«Empieza tu colección» usa línea inferior `1px` en `link-border`, gap `35px`, fuente `0.9rem`/700 y hover `link-hover`. «Conoce TuriPlay» usa fuente label, gap `24px`, margen izquierdo `28px` y hover ámbar; en móvil ocupa su propia línea.

### Feature items

Tres artículos planos sobre la banda salvia: subir, reproducir y descargar. Icono de línea, h3 y párrafo; primer artículo con padding de `feature-item`, siguientes con padding izquierdo `35px` y divisor vertical. Sin hover específico, sombra ni interacción de tarjeta. El aviso de privacidad es una fila de icono candado y texto pequeño (`0.78rem`, móvil `0.75rem`), no un badge de estado.

### Steps

Lista ordenada con tres filas; cada una combina número circular de `35px`, gap `22px`, h3 y descripción. Padding `25px 0`, primera fila sin padding superior, divisor inferior en `step-border`; la regla móvil de `22px 0` vuelve a dar padding superior a la primera fila. No son controles interactivos.

### Hero and closing band

Hero con imagen local `public/images/landing/machu-picchu.jpg`, dimensiones declaradas `2000×1333`, texto alternativo, preload y prioridad alta. El texto se superpone mediante capas aisladas y conserva el crédito de ubicación. El cierre es una banda ámbar con h2, descripción y CTA invertido; no utiliza una segunda fotografía.

La landing no implementa inputs, formularios, filtros, chips ni modales; enlaza a `/explorar`, catálogo paginado de videos publicados voluntariamente. La ficha de cada video muestra reproductor, likes y comentarios. Registro e inicio siguen en Filament; los usuarios autenticados vuelven al video mediante la redirección prevista.

## Do's and Don'ts

### Do:
- **Do** mantener el ámbar como acción de registro y el verde profundo como estructura y contraste.
- **Do** conservar Barlow Condensed 600 en h1/h2 y la pila Instrument Sans para cuerpo e interfaz.
- **Do** preservar las anclas, el salto al contenido, el foco visible y la preferencia de movimiento reducido.
- **Do** representar las funcionalidades como filas o columnas planas separadas por líneas.

### Don't:
- **Don't** presentar como públicos los videos que sus dueños no hayan publicado ni añadir pruebas comerciales inexistentes.
- **Don't** propagar la tipografía o los componentes de esta landing al panel Filament sin un encargo explícito.
- **Don't** documentar inputs, sombras, menús móviles o estados que esta landing no implementa.
- **Don't** afirmar que Instrument Sans está cargada solo porque aparece declarada en la pila CSS.

## Exploración pública — ampliación posterior

La landing conserva su hero fotográfico y añade una banda editorial con acceso a Explorar. `/explorar` muestra videos públicos paginados, tarjetas planas con ubicación y autor; no descarga archivos ni carga reproductores en la lista. `/explorar/{video}` reproduce el archivo privado solo si el dueño lo publicó; muestra comentarios visibles al instante, y solicita iniciar sesión para dar me gusta o comentar. La nueva sección y las páginas conservan verde profundo, ámbar, tipografía y enfoque responsive de la landing. El panel permite publicar o retirar la publicación de cada video, privado por defecto.

El rojo `error` se reserva para mensajes de validación del comentario. Los tamaños `.78rem`, `.9rem`, `1.2rem`, `3.4rem` y `.76rem` de la ampliación mantienen la escala editorial existente sin alterar los tamaños de los títulos principales ni del panel.


## Panel interno — extensión aprobada

**Alineación del shell:** desde 1024px el sidebar es fijo y empieza en y=0; su cabecera y navbar miden `--topbar-height` (64px). Navbar y contenido se desplazan con el ancho nativo del sidebar (320px abierto / 72px plegado); la marca se presenta una sola vez en el sidebar. En móvil se conserva el overlay nativo.

**Iconografía de navegación:** pictogramas de sidebar de 20×20px, navbar de 18×18px, avatar y símbolo de marca de 28×28px. Se mantiene un área mínima de 40×40px en botones de icono y filas laterales de 46px. Separación icono/texto de 10px y trazo de 1.7 en iconos laterales outline; el comportamiento responsive y el colapso nativo no se reemplazan.

El encargo posterior amplía la identidad al panel `/admin`, sin cambiar la landing ni sustituir componentes funcionales de Filament. Modo Operate: navegación estable, tipografía Inter Variable nativa y jerarquía compacta; no se utiliza Barlow Condensed en formularios o tablas.

- **Implementación:** `public/css/turiplay-panel.css`, cargado mediante `PanelsRenderHook::HEAD_END`; marca en `filament.partials.brand`; no requiere cambiar Vite, `.env` ni configuración de entorno.
- **Navegación:** barra lateral verde #142c28, selección ámbar #f5b544; colapso nativo en escritorio y apertura modal nativa en móvil. Se conservan búsqueda global, menú de cuenta y cierre de sesión.
- **Superficies:** lienzo #f2f5f1, contenido blanco, texto #193b32 y secundario #576b61; radios de 14px en secciones y 8px en controles. Sombra suave `0 2px 7px rgb(20 44 40 / 4%)`.
- **Tipografía:** encabezado 1.75rem (1.5rem hasta 1023px y 1.4rem hasta 640px), descripción .9rem/.85rem, métricas 1.9rem/1.65rem. La escala de la landing permanece separada.
- **Dashboard:** títulos según rol, acción Subir video autorizada por `VideoResource::canCreate()`, widgets existentes conservados. Resumen por usuario en lista de definición de tres columnas, apilada en móvil, con actualización `aria-live`.
- **Recursos:** secciones nativas para datos/acceso de usuario y destino/archivo de video; campos, validaciones, acciones, columnas y autorización conservados. Tablas con títulos de peso medio y estados vacíos explicativos.
- **Oscuro:** tokens `panel-dark-*` registrados arriba. Sidebar mantiene el verde; superficie y texto cambian con `.dark`. Foco visible y movimiento reducido preservados.
- **Verificación:** capturas de administrador y usuario en `.impeccable/review-panel/`; escritorio 1440px, móvil 390px y modo oscuro. Formularios y listados responden 200; sin overflow horizontal ni errores JS en las vistas verificadas. Los datos visibles son fixtures en una base temporal aislada.
