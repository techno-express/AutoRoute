# CHANGELOG

## 1.1.0

- Add `autoroute-create` functionality to create class file from HTTP verb and
  URL path

- Update docs.

## 1.0.1

- backslash PHP built-in functions, giving micro-optimization.
- rework `getFiles()` method to use PHP `glob` function, giving better Windows OS support.
- bug fix `fileToClass()` needs `substr` to check for false, otherwise the call to `actionExists` method throws TypeError.

## 1.0.0

First stable release.
