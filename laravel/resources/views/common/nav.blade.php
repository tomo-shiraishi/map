<header>
  <h1>周辺施設マップ</h1>
  <nav>
    <ul>
      <li @if (Request::url() == Request::root()) class="active" @endif><a href="/">マップ</a></li>
      <li{{ (Request::is('restaurants*') && strpos(Request::path(), '/add') === false) ? ' class=active' : '' }}><a href="/restaurants">お店一覧</a></li>
      <li{{ (Request::is('restaurants/add*')) ? ' class=active' : '' }}><a href="/restaurants/add">お店追加</a></li>
      <li{{ (Request::is('category*') && strpos(Request::path(), '/add') === false) ? ' class=active' : '' }}><a href="/category">カテゴリ一覧</a></li>
      <li{{ (Request::is('category/add*')) ? ' class=active' : '' }}><a href="/category/add">カテゴリ追加</a></li>
    </ul>
  </nav><!-- /navbar -->
  <p><a href="/company">拠点情報</a></p>
</header>
