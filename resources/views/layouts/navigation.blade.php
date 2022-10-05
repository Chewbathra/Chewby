<nav class="chewby__navbar">
    <div class="chewby__navbar__brand">
        <a href="#" class="chewby__brand__link">
            <x-icon-globe style="width: 40px; height: 32px;" />
            <span>{{config("app.name")}}</span>
        </a>
    </div>
    <ul class="chewby__nav">
        <li class="chewby__nav__item">
            <a href="#" class="chewby__nav__link">
                <x-icon-home />
                <span>Accueil</span>
            </a>
        </li>
        <li class="chewby__nav__item chewby__nav__item--active">
            <a href="#" class="chewby__nav__link">
                <x-icon-edit />
                <span>Article</span>
            </a>
        </li>
        <li class="chewby__nav__item">
            <a href="#" class="chewby__nav__link">
                <x-icon-settings />
                <span>Paramètres</span>
            </a>
        </li>
        <li class="chewby__nav__item">
            {{-- {{ route('logout') }} --}}
            <form method="POST" action="" class="chewby__nav__logout">
                    @csrf
                    <a class="chewby__nav__link" submit-form-on-click>
                        <x-icon-log-out />
                        <span>Déconnexion</span>
                    </a>
                </form>
        </li>
    </ul>
</nav>
