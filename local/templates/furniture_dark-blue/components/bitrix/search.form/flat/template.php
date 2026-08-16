<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form action="<?=$arResult["FORM_ACTION"]?>" class="board-search__form">
    <input type="text" name="q" maxlength="50"
           autocomplete="off"
           placeholder=" "
           class="board-search__input">
    <button type="submit" name="s" class="board-search__btn"><?=GetMessage("BSF_T_SEARCH_BUTTON")?></button>
</form>