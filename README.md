## 機能説明

- TODOリスト機能を提供するWebアプリケーション
- ユーザーの概念はない（認証の概念もない）
- TODO 1つをタスクと呼称する
- タスクを追加・編集ができる
- タスクの並び替えはできない
- タスクをアーカイブできる

## 構成

- REST API を Laravel で構築
    - ディレクトリ構成は Laravel 標準に近い状態
    - Laravel 10.x
    - PHP 8.1
- クライアントサイドは Vue3 で構築
    - resources/js 以下に構築
    - Node 18.x
    - Vue 3.x

## server side

```
composer i
php artisan serve
```

- http://localhost:8000/ が起動する

## client side

```
cd resources/js
npm i
npm run dev
```

- http://localhost:5173/ が起動する
