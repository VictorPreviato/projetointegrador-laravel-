@echo off
REM ================================
REM Start Laravel usando PHP embutido
REM ================================

echo ===============================
echo   Iniciando Laravel Server
echo ===============================
pause

REM Caminho do php.ini na raiz do projeto
set PHP_INI_PATH=%CD%\php.ini

REM Caminho do PHP (ajuste se nao estiver no PATH)
set PHP_EXEC=php

REM Verifica se o PHP está acessível
%PHP_EXEC% -v
IF ERRORLEVEL 1 (
    echo ERRO: PHP nao encontrado! Ajuste PHP_EXEC no .bat
    pause
    exit /b
)

REM Escolhe porta livre a partir da 8000
set PORT=8000
:checkPort
netstat -ano | findstr :%PORT% >nul
IF NOT ERRORLEVEL 1 (
    set /a PORT=%PORT%+1
    goto checkPort
)

echo Porta escolhida: %PORT%
echo Iniciando servidor PHP embutido Laravel em http://127.0.0.1:%PORT% ...

REM Abre o navegador em paralelo (não bloqueia o servidor)
start "" http://127.0.0.1:%PORT%

REM Roda o servidor PHP embutido apontando para public (fica no CMD)
%PHP_EXEC% -c "%PHP_INI_PATH%" -S 127.0.0.1:%PORT% -t public

REM Quando fechar o servidor, o CMD permanece aberto
pause
