@echo off
setlocal enabledelayedexpansion

:: Demande le nom du commit
set /p commitName="Nom du Commit : "

:: Demande la description du commit
echo Entrez la description du commit (finissez par une ligne vide) :
set "description="

:descLoop
set /p line="> "
if "!line!"=="" goto descEnd
if "!line!"==" " goto descEnd
set "description=!description!!line!"
goto descLoop

:descEnd

:: Liste des changements
echo Entrez les changements (tapez FIN pour arrêter) :
set "changes="
:changeLoop
set /p change="- "
if /i "!change!"=="FIN" goto changeEnd
if "!change!"=="" goto changeLoop
set "changes=!changes!!change!"
goto changeLoop

:changeEnd

:: Construction du message de commit
set "commitMessage=Nom du commit: %commitName%"
set "commitMessage=!commitMessage!\n- Desc :"
for %%a in (!description!) do (
    set "commitMessage=!commitMessage!\n  - %%a"
)
set "commitMessage=!commitMessage!\n- Change :"
for %%b in (!changes!) do (
    set "commitMessage=!commitMessage!\n  - %%b"
)

:: Affichage formaté du commit
echo.
echo Aperçu du commit :
echo !commitMessage!
echo.

:: Confirmation du commit
set /p confirm="Valider le commit ? (O/N) : "
if /i "%confirm%" NEQ "O" exit /b

:: Ajout des fichiers modifiés à l'index de Git
git add .

:: Tentative de commit
git commit -m "!commitMessage!"
if %errorlevel% NEQ 0 (
    echo Erreur lors du commit.
    exit /b
)

echo Commit effectué avec succès !

:: Synchronisation avec le dépôt distant (git push)
echo Synchronisation avec le dépôt distant...
git push
if %errorlevel% NEQ 0 (
    echo Erreur lors de la synchronisation.
    exit /b
)

echo Synchronisation effectuée avec succès !
