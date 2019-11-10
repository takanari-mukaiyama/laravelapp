@extends("layouts.app")

@section("title", "ポートフォリオ紹介ページ")

@section("content")
<div class="container portfolio card">
  <h1>ポートフォリオ紹介ページ</h1>
  <h2>概要</h2>
<p>私が作成したポートフォリオの解説になります</p>
<p>アプリケーションへは当ページの左上ロゴからアクセス可能です</p>
<p>確認用として以下のアカウントを発行しております</p>
<p>管理権限：998 / @Admin123!</p>
<p>一般ユーザ：999 / @User123!</p>
<br>
<h2>背景</h2>
<p>現在、弊社には会社で管理している技術書等の図書が存在し、社員への貸し出しを行っております</p>
<p>盗難防止の為、図書の保管庫に入室したり図書を借りる際には総務部を通す必要があり、</p>
<p>入室記録や貸し出し履歴等は全て管理台帳に記録する事になっております</p>
<p>借りた図書は一週間以内に返却するルールとなっております</p>
<br>
<p>先日、経営会議により、以下の事項が決定しました</p>
<p>・運営方針としてペーパーレス化を推進</p>
<p>・社員数増加に伴いレンタルオフィスのフロアを追加、総務部含む事務系部署は追加フロアに移動</p>
<p>・図書の返却期限遵守率が低下傾向にあり苦情が増えている為、返却期限を超過した際にペナルティを付与</p>
　<p>　→返却期限を過ぎた時間分だけ、図書の借受禁止というルールに決定</p>
<br>
<p>これにより、以下の問題が発生する事が想定されます</p>
<p>・管理台帳のデータ化、或いは社員が図書保管庫に立ち入る必要のない仕組みの構築が必要</p>
<p>・本棚が別フロアとなり、移動の手間が大幅に増える為、図書が貸し出し可能か確認するのが面倒になる</p>
<p>・社員のペナルティを管理する手間がかかる</p>
<br>
<p>その為、これらの問題を解消するために、図書管理アプリケーションを作成する事になりました</p>
<br>
<h2>目的</h2>
<p>・上述した問題を解消する</p>
<p>・フルスクラッチのWebアプリケーション開発経験を積む</p>
<p>・AWSで環境を構築する事で、環境構築とAWSの知識を蓄える</p>
<p>・Laravelを使用し、フレームワークの経験を積む</p>
<p>・Githubに触る事で、知識を蓄える</p>
<br>
<h2>環境</h2>
<h4>言語</h4>
<p>PHP7.3.9</p>
<h4>データベース</h4>
<p>Mysql5.7.26</p>
<h4>フレームワーク</h4>
<p>Laravel 5.8.35</p>
<h4>サーバー</h4>
<p>Amazon Linux AMI</p>
<h4>ソースコード管理</h4>
<p>git version 2.14.5</p>
<br>
<h2>要件</h2>
<p>アプリケーションにログインする事で各種機能を使用できます</p>
<p>主な機能は</p>
<p>・新着情報</p>
<p>　→図書やアプリケーションに関するニュースを見る事が出来ます</p>
<br>
<p>・図書閲覧</p>
<p>　→現在社内で管理している図書の閲覧ができるフリーワード検索が可能で、図書が貸出可能かどうかもわかります</p>
<br>
<p>・ユーザー関連</p>
<p>　→各ユーザーの情報の変更の他、ペナルティ期間等の変更も出来ます</p>
<br>
<p>アカウントには３種の権限を設定できます</p>
<p>１．システム管理権限</p>
<p>２．管理権限</p>
<p>３．一般ユーザ</p>
<br>
<p>システム管理権限は管理権限と同等だが、主に開発者用の隠し権限とします</p>
<br>
<p>一般ユーザで使用できる機能には制限がある以下のうち★マークは一般ユーザでは使用不可</p>
<p>・図書一覧の閲覧</p>
<p>・図書詳細の閲覧</p>
<p>★図書の新規登録・編集・削除・貸出・返却</p>
<p>★ユーザ一覧の閲覧</p>
<p>・ユーザ詳細の閲覧</p>
<p>・社員ID、名前、メールアドレス、パスワードの変更</p>
<p>★ペナルティ期間、権限の変更</p>
<p>・新着情報一覧の閲覧</p>
<p>・新着情報詳細の閲覧</p>
<p>★新着情報の新規登録・編集・削除</p>
<br>
<h2>設計</h2>
<h4>データベース設計</h4>
<a href="/storage/db.jpg"><img src="/storage/db.jpg"></a>
<h4>GUI設計</h4>
<p>赤枠・赤線は管理者権限のみアクセス可能＆表示する機能、画面になります</p>
<a href="/storage/gui.jpg"><img src="/storage/gui.jpg" style="width:1000px"></a>
<h2>ソースコード</h2>
<p><a href="https://github.com/takanari-mukaiyama/laravelapp">こちら</a>にアップロードしております</p>
<h2>課題・問題点</h2>
<p>一通りの要件を満たした所で完成としましたが、</p>
<p>テスト運用によりいくつかの問題点が上がった点や、</p>
<p>開発中に自身で気づいた点等をまとめます</p>
<br>
<h4>Chrome以外のブラウザでデザインがおかしくなる事がある</h4>
<p>CSSの調整が不十分な為、ブラウザによってデザインが異なる部分が発生し、一部でデザイン崩れが生じている</p>
<br>
<h4>図書返却を促す為の機能が現状無い</h4>
<p>期限超過時の事後対策はしたものの、事前対策はしていない</p>
<p>返却期限が近い事を通知するメールを送信したり、期限超過者の一覧が見れるページ等があればよかった</p>
<br>
<h4>パスワードのリセットが出来ない</h4>
<p>パスワードを忘れた場合にはシステム管理者に再発行を依頼する必要があり、自分でメールアドレス等の入力による再発行が出来ない</p>
<br>
<h4>migrateをあまり使用していない</h4>
<p>Laravelの機能の一つであるマイグレーションをあまり使用していない</p>
<p>今回は社内用ツールという事であまりバージョン管理については重視されていないが、</p>
<p>開発者としてデータベース管理もしっかりと学ぶ必要がある</p>
<br>
<h2>今後について</h2>
<p>当面は課題・問題点についての解消を図って行きたいと考えております</p>
<p>また、今回の開発では自身の考慮不足による設計修正や変更が多かった為、</p>
<p>今後は設計の勉強にも力を入れてより品質の高いシステムが作れるよう尽力して行きたいです</p>
</div>
@endsection
