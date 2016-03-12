# Projet-Licore
Projet de Master 1  : sujet 6

# Gulp
Gulp est utilisé pour :
* compiler le SASS en CSS
* concatener et minifier les fichiers JS
* construire une archive contenant seulement les fichiers nécessaires au site

## Prérequis
* Installez nodeJS : https://nodejs.org/en/
* Ouvrir une console à la racine du projet (dans le dossier où se trouve le package.json)
* Entrez la commande suivante pour installer les dépendances :
```
npm install
```
## Utilisation
Entrez la commande suivante pour executer les tâches gulp pour compiler le SASS en CSS et concatener+minifier les fichiers JS:
```
npm run gulp
```
Les fichiers générés se trouvent dans le dossier "dist".

Entrez la commande suivante pour executer la construction de l'archive contenant seulement les fichiers nécessaires au site:
```
npm run build
```
Les fichiers générés se trouvent dans le dossier "build".
