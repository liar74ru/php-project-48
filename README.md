# Gendiff

### Hexlet tests and linter status:
[![hexlet-check](https://github.com/liar74ru/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/liar74ru/php-project-48/actions/workflows/hexlet-check.yml)
[![CI](https://github.com/liar74ru/php-project-48/actions/workflows/ci.yml/badge.svg)](https://github.com/liar74ru/php-project-48/actions/workflows/ci.yml)
[![SonarQube Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=liar74ru_php-project-48&metric=alert_status)](https://sonarcloud.io/dashboard?id=liar74ru_php-project-48)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=liar74ru_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=liar74ru_php-project-48)

---

## Описание

Учебный проект по PHP для платформы Hexlet.  
В проекте реализован CLI-инструмент для сравнения файлов в форматах JSON и YAML с поддержкой различных форматов вывода (`stylish`, `plain`, `json`).

---

## Установка

1. Склонируйте репозиторий:
    ```bash
    git clone https://github.com/liar74ru/php-project-48.git
    ```
2. Перейдите в директорию проекта:
    ```bash
    cd php-project-48
    ```
3. Установите зависимости с помощью Composer:
    ```bash
    make install
    ```

---

## Принцип работы

**Gendiff** — это инструмент для поиска различий между двумя конфигурационными файлами (JSON, YAML).  
Он строит древовидное представление изменений, показывая, какие ключи были добавлены, удалены, изменены или остались без изменений, включая вложенные структуры.

### Как это работает

1. **Парсинг файлов:**  
   Оба файла преобразуются в ассоциативные массивы.

2. **Построение дерева различий:**  
   Для каждого ключа из объединённого множества ключей обоих файлов определяется его статус:
   - `added` — ключ есть только во втором файле;
   - `deleted` — ключ есть только в первом файле;
   - `unchanged` — значения совпадают;
   - `updated` — значения различаются;
   - `nested` — если значения по ключу — вложенные объекты, сравнение происходит рекурсивно;
   - `deletedNested` — значение — массив, и оно было удалено;
   - `addedNested` — значение — массив, и оно было добавлено.

3. **Форматирование результата:**  
   Полученное дерево различий преобразуется в строку в одном из поддерживаемых форматов:
   - **stylish** (по умолчанию, древовидный вид)
   - **plain** (текстовое описание изменений)
   - **json** (машиночитаемый формат)

---

## Пример использования

```bash
./bin/gendiff --format plain file1.json file2.json
```

---

## Демонстрации

### После 4 шага

[![asciicast](https://asciinema.org/a/iBiPVHLDxXnUNdbyShAxkR48j.svg)](https://asciinema.org/a/iBiPVHLDxXnUNdbyShAxkR48j)

### После 6 шага

[![asciicast](https://asciinema.org/a/ffUVpt3LGrEOtvnfw2Xb5p5wI.svg)](https://asciinema.org/a/ffUVpt3LGrEOtvnfw2Xb5p5wI)

### После 7 шага

[![asciicast](https://asciinema.org/a/lv3ORtfuHh3E9UDWWqfierQYS.svg)](https://asciinema.org/a/lv3ORtfuHh3E9UDWWqfierQYS)

### После 8 шага

[![asciicast](https://asciinema.org/a/fw6KHyqwRNZBJTunTI8siOdRV.svg)](https://asciinema.org/a/fw6KHyqwRNZBJTunTI8siOdRV)

### После 9 шага

[![asciicast](https://asciinema.org/a/1Sr5xQLggvnxrGZIFs1l54UpI.svg)](https://asciinema.org/a/1Sr5xQLggvnxrGZIFs1l54UpI)

---