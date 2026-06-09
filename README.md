# Gridlock - Web Accident Viewer

Presentation video: https://drive.google.com/file/d/1vCncoDvNfsPPW31ftSzE3WzkUUHu7AMe/view?usp=sharing  
C4 Diagrams are in `/diagrams/`

## Project Details

### Architecture used: 
MVC with `/models`, `/views`, `/controllers`.  
Styles and Javascript files are found in `/public/`.

### Website functionality

1. Interactive Map View with markers and heatmap
2. List View of Accidents with an OpenStreetMap link to location
3. Advanced Querying for State, Severity and Weather Conditions
4. Profile for saving specific queries and loading them later
5. Export in WebP, SVG and CSV formats
6. Statistics and Charts in map view.

### API Calls

`/api/accidents` - Returns a JSON structure that includes all the accidents following a specific query.  
`/api/accidents/stats` - Returns the statistical view of the accidents following a specific query.
