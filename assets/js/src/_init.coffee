(($) ->
  "use strict"

  $.each $("[data-bt-icon]"), (index, element) ->
    $this = $(element)

    svg = document.createElementNS 'http://www.w3.org/2000/svg', 'svg'
    svg.setAttribute 'class', $this.attr 'class'

    use = document.createElementNS('http://www.w3.org/2000/svg', 'use')
    use.setAttributeNS(
      'http://www.w3.org/1999/xlink',
      'href',
      svgSpritePath + '#' + $this.data 'btIcon'
    )

    svg.appendChild use
    $this.replaceWith svg
    return

  # Placeholder
  $('[placeholder]').placeholder()

  return
) jQuery