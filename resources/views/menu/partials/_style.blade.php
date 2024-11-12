<style>
:root {
    --body_color1: #f0eabe;
    --body_color2: #bfead7;
    @if(empty($theme)) --primary-color: #bfead7;

    @else --primary-color: {
            {
            $theme
        }
    }

    ;
    @endif @if(empty($rest->background_color)) --background-color: linear-gradient(to right, var(--body_color1), var(--body_color2));
    ;

    @else --background-color: {
            {
            $rest->background_color
        }
    }

    ;
    @endif @if(empty($rest->frame_color)) --frame-color: #ffffff;

    @else --frame-color: {
            {
            $rest->frame_color
        }
    }

    ;
    @endif @if(empty($rest->icon_color)) --primary_color: #ffffff;

    @else --primary_color: {
            {
            $rest->icon_color
        }
    }

    ;
    @endif
}

main {
    background: var(--background-color);
}

main>div {
    background: var(--frame-color);
}

main .left-side .left-side-title {
    background-color: var(--primary-color);
}

main .left-side .left-side-content .items .item .item-desc {
    background-color: var(--primary-color);
}

main .center-side .cone-desc {
    background-color: var(--primary-color);
}


main .right-side .time-elem {
    background-color: var(--primary-color);
}

main .right-side .logo {
    background-color: var(--primary-color);
}

.hide {
    display: none;
    transition: opacity 0.5s;
    opacity: 0;
}

.show {
    opacity: 1;
    transition: opacity 0.5s;
}
</style>