<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */
$r = $arResult['REQUEST'];
?>
<div class="board-filter">
    <form action="<?=$arResult['LIST_URL']?>" method="get" class="board-filter__form">

        <div class="board-filter__row">
            <label class="board-filter__label">Поиск по названию</label>
            <input type="text" name="q" value="<?=htmlspecialcharsbx($r['q'])?>"
                   class="board-filter__input" placeholder="Например: диван">
        </div>

        <?php if (!empty($arResult['CATEGORIES'])): ?>
            <div class="board-filter__row">
                <label class="board-filter__label">Категория</label>
                <select name="category" class="board-filter__input">
                    <option value="">Все категории</option>
                    <?php foreach ($arResult['CATEGORIES'] as $cat): ?>
                        <option value="<?=$cat['ID']?>"<?=($r['category'] == $cat['ID'] ? ' selected' : '')?>>
                            <?=htmlspecialcharsbx($cat['VALUE'])?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        <?php endif ?>

        <?php if (!empty($arResult['CITIES'])): ?>
            <div class="board-filter__row">
                <label class="board-filter__label">Город</label>
                <select name="city" class="board-filter__input">
                    <option value="">Любой город</option>
                    <?php foreach ($arResult['CITIES'] as $city): ?>
                        <option value="<?=htmlspecialcharsbx($city)?>"<?=($r['city'] === $city ? ' selected' : '')?>>
                            <?=htmlspecialcharsbx($city)?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        <?php endif ?>

        <div class="board-filter__row">
            <label class="board-filter__label">Цена, руб.</label>
            <div class="board-filter__range">
                <input type="text" name="price_from" value="<?=htmlspecialcharsbx($r['price_from'])?>"
                       class="board-filter__input board-filter__input--sm" placeholder="от">
                <input type="text" name="price_to" value="<?=htmlspecialcharsbx($r['price_to'])?>"
                       class="board-filter__input board-filter__input--sm" placeholder="до">
            </div>
        </div>

        <button type="submit" class="board-filter__btn">Показать</button>

        <?php if ($arResult['IS_FILTERED']): ?>
            <a href="<?=$arResult['LIST_URL']?>" class="board-filter__reset">Сбросить</a>
        <?php endif ?>

    </form>
</div>
