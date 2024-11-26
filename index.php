<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="habbex.png">
    <title>Habbex!</title>
    <script type="module" src="https://cdn.skypack.dev/tweakpane@4.0.4"></script>
	 <script type="module" src="https://cdn.skypack.dev/splitting"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap');
@import url('https://unpkg.com/normalize.css') layer(normalize);
/* @import 'normalize.css' layer(normalize); */

@layer normalize, base, demo, debug;

@layer debug {
  [data-debug='true'] main a:not(:nth-of-type(2)) {
    opacity: 0.1;
  }

  [data-debug='true'] main a:nth-of-type(2) .char {
    overflow: visible;
    outline: 0.05em hotpink dashed;
  }
}

@layer demo {
  :root {
    --duration: 0.25;
  }
  body {
  background: light-dark(#fff, #000); /* Fondo principal */
  position: relative;
  margin: 0;
  min-height: 100vh; /* Asegura que cubra toda la pantalla */
}

body::after {
  content: '';
  position: absolute;
  bottom: 0;
  right: 0;
  width: 484px; /* Ajusta el tamaño deseado de la imagen */
  height: 463px; /* Ajusta el tamaño deseado de la imagen */
  background: url('derecha.png') no-repeat center center;
  background-size: contain; /* Ajusta para que la imagen se ajuste al contenedor */
  opacity: 0.5; /* Opacidad del 50% */
  pointer-events: none; /* La imagen no interfiere con los clics */
}
  main {
    display: flex;
    flex-direction: column;
  }
  main a {
    --font-level: 5.8;
    font-weight: 300;
    color: inherit;
    font-family: 'Reddit Mono', monospace;
    text-transform: uppercase;
    text-decoration: none;
    transition: opacity 0.2s;
    opacity: 0.7;

    &:is(:hover, :focus-visible) {
      opacity: 1;
    }

    &:last-of-type {
      --font-level: 1.2;
      opacity: 0.6;
    }
  }

  hr {
    margin-block: 2rem;
    background: canvasText;
    height: 2px;
    width: 100%;
  }

  .word {
    letter-spacing: -0.3ch;
  }

  a,
  .word,
  .words,
  .char {
    display: inline-flex;
    line-height: 1;
    height: min-content;
  }

  /* text lines styling */
  [data-char] {
    width: 0.94ch;
    height: 1lh;
    overflow: hidden;
    position: relative;
    display: inline-block;
    line-height: 1;
  }

  [data-char] span {
    --delay: calc(
      (
        sin((var(--char-index) / var(--char-total)) * 90deg) *
          (var(--duration) * 1)
      )
    );
    position: absolute;
    width: 1ch;
    translate: -50% 0;
    word-break: break-word;
    white-space: break-spaces;
    bottom: 0%;
    left: 50%;
  }

  a:is(:hover, :focus-visible) [data-char] span {
    transition: translate calc(var(--duration) * 1s)
      calc(0.1s + (var(--delay) * 1s)) steps(calc(var(--steps) + 1));
    translate: -50% calc(100% - 1lh);
  }

  .word {
    line-height: 1;
    white-space: nowrap;
    height: 100%;
  }
}

@layer base {
  :root {
    --font-size-min: 16;
    --font-size-max: 20;
    --font-ratio-min: 1.2;
    --font-ratio-max: 1.33;
    --font-width-min: 375;
    --font-width-max: 1500;
  }

  html {
    color-scheme: light dark;
  }

  [data-theme='light'] {
    color-scheme: light only;
  }

  [data-theme='dark'] {
    color-scheme: dark only;
  }

  :where(.fluid) {
    --fluid-min: calc(
      var(--font-size-min) * pow(var(--font-ratio-min), var(--font-level, 0))
    );
    --fluid-max: calc(
      var(--font-size-max) * pow(var(--font-ratio-max), var(--font-level, 0))
    );
    --fluid-preferred: calc(
      (var(--fluid-max) - var(--fluid-min)) /
        (var(--font-width-max) - var(--font-width-min))
    );
    --fluid-type: clamp(
      (var(--fluid-min) / 16) * 1rem,
      ((var(--fluid-min) / 16) * 1rem) -
        (((var(--fluid-preferred) * var(--font-width-min)) / 16) * 1rem) +
        (var(--fluid-preferred) * var(--variable-unit, 100vi)),
      (var(--fluid-max) / 16) * 1rem
    );
    font-size: var(--fluid-type);
  }

  *,
  *:after,
  *:before {
    box-sizing: border-box;
  }

  body {
    display: grid;
    place-items: center;
    min-height: 100vh;
    font-family: 'SF Pro Text', 'SF Pro Icons', 'AOS Icons', 'Helvetica Neue',
      Helvetica, Arial, sans-serif, system-ui;
  }

  body::before {
    --size: 45px;
    --line: color-mix(in lch, canvasText, transparent 70%);
    content: '';
    height: 100vh;
    width: 100vw;
    position: fixed;
    background: linear-gradient(
          90deg,
          var(--line) 1px,
          transparent 1px var(--size)
        )
        50% 50% / var(--size) var(--size),
      linear-gradient(var(--line) 1px, transparent 1px var(--size)) 50% 50% /
        var(--size) var(--size);
    mask: linear-gradient(-20deg, transparent 50%, white);
    top: 0;
    transform-style: flat;
    pointer-events: none;
    z-index: -1;
  }

  .bear-link {
    color: canvasText;
    position: fixed;
    top: 1rem;
    left: 1rem;
    width: 48px;
    aspect-ratio: 1;
    display: grid;
    place-items: center;
    opacity: 0.8;
  }

  :where(.x-link, .bear-link):is(:hover, :focus-visible) {
    opacity: 1;
  }

  .bear-link svg {
    width: 75%;
  }

  /* Utilities */
  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
  }
}
.tp-rotv {
    background-color: hsl(54.69deg 58.5% 34.37% / 28%)!important;
  
}

    </style>
</head>
<body>
  <main>
      <a
        class="fluid"
     
        rel="noopener noreferrer"
        href="#hbx"
      >
        <span aria-hidden="true" data-splitting="">....</span>
        <span class="sr-only"></span>
      </a>
      <a
        class="fluid"
       
        rel="noopener noreferrer"
       href="#hbx"
      >
        <span aria-hidden="true" data-splitting="">....s</span>
        <span class="sr-only">HBX</span>
      </a>
      <hr />
      <a
        class="fluid"
       
        rel="noopener noreferrer"
        href="#hbx"
      >
        <span aria-hidden="true" data-splitting="">.....</span>
        <span class="sr-only">¡El final está cerca, la diversión está por comenzar!</span>
      </a>
    </main>
    <a
      class="bear-link"
      href="#modal"
      
      rel="noreferrer noopener"
    >
      <img src="habbexdiv.png">
    </a>
	
    <script type="module">
       import { Pane } from 'https://cdn.skypack.dev/tweakpane@4.0.4'
import Splitting from 'https://cdn.skypack.dev/splitting'

const config = {
  theme: 'dark',
  debug: false,
  track: 10,
  random: false,
  speed: 0.25,
}

// Utilities for building random strings
const defaultChars =
  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?~'
const randomString = (length, chars = defaultChars) => {
  return [...Array(length)]
    .map(() => chars[Math.floor(Math.random() * chars.length)])
    .join('')
}

// For escaping the special characters for HTML output:
const escapeHTML = (str) =>
  str.replace(
    /[&<>"']/g,
    (char) =>
      ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
      }[char])
  )

const getWords = (txt) => {
  const hold = Object.assign(document.createElement('div'), {
    innerHTML: Splitting.html({ content: txt, whitespace: true }),
  })

  const chars = hold.querySelectorAll('.char, .whitespace')
  hold.firstChild.setAttribute('aria-hidden', 'true')
  for (let c = 0; c < chars.length; c++) {
    const char = chars[c]
    char.dataset.char = char.innerHTML
    char.innerHTML = `<span>${char.innerHTML}${escapeHTML(
      randomString(
        config.track || 6,
        config.random ? defaultChars : txt.replace(/\s/g, '')
      ) + char.innerHTML
    )}</span>`
  }

  return hold.innerHTML
}

const build = () => {
  const links = document.body.querySelectorAll('main a')
  for (const link of links) {
    const animated = link.querySelector('[aria-hidden]')
    const text = link.querySelector('.sr-only').innerText
    const word = getWords(text)
    animated.replaceWith(
      Object.assign(document.createElement('div'), { innerHTML: word })
        .firstChild
    )
  }
}

const ctrl = new Pane({
  title: 'Habbex panel',
  expanded: true,
})

const update = (event) => {
  document.documentElement.dataset.theme = config.theme
  document.documentElement.dataset.debug = config.debug
  document.documentElement.style.setProperty('--steps', config.track)
  document.documentElement.style.setProperty('--duration', config.speed)
  if (!event || event.last) build()
}

const sync = (event) => {
  if (
    !document.startViewTransition ||
    event.target.controller.view.labelElement.innerText !== 'Theme'
  )
    return update(event)
  document.startViewTransition(() => update(event))
}

ctrl.addBinding(config, 'random', {
  label: 'Aleatorio',
})

ctrl.addBinding(config, 'track', {
  label: 'Efecto',
  min: 1,
  max: 20,
  step: 1,
})
ctrl.addBinding(config, 'speed', {
  label: 'Velocidad (s)',
  min: 0.1,
  max: 2,
  step: 0.01,
})

ctrl.addBinding(config, 'debug', {
  label: 'Debug',
})

ctrl.addBinding(config, 'theme', {
  label: 'Theme',
  options: {
    System: 'system',
    Light: 'light',
    Dark: 'dark',
  },
})

ctrl.on('change', sync)
update()


    </script>
</body>
</html>