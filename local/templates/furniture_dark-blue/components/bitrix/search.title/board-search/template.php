<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form action="<?=$arResult["FORM_ACTION"]?>" class="board-search__form">
    <input type="text"
           id="<?=$arParams["INPUT_ID"]?>"
           name="q"
           value=""
           autocomplete="off"
           placeholder="Что ищем? Например: Skoda Octavia"
           class="board-search__input">
    <button type="submit" name="s" class="board-search__btn">Найти</button>
</form>
