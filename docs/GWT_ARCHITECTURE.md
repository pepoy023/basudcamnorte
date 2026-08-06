# GWT Theme Architecture

## Entry Point

functions.php

## Initialization

inc/function-initialize.php

## Scripts

inc/function-enqueue-scripts.php

## Widgets

18 widget areas

- Banner Section 1
- Banner Section 2
- Ear Content 1
- Ear Content 2
- Panel Top 1-4
- Panel Bottom 1-4
- Left Sidebar
- Right Sidebar
- Agency Footer 1-4

## Navigation

- Auxiliary Menu
- Custom Foundation Walker Classes

## PHP 8 Compatibility Progress

Completed:
- Fixed `get_option()` returning `false`
- Added safe defaults for missing theme options
- Fixed `govph_logo`
- Fixed breadcrumbs compatibility
- Fixed classic editor option warnings
- Fixed slider option warnings

Remaining:
- Envato Flex Slider (`$count`, `$slider`)