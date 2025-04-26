<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title">Связаться</div>
        <div class="contact-form__head-text">
            Наши сотрудники помогут выполнить подбор
            услуги и&nbsp;расчет цены с&nbsp;учетом
            ваших требований
        </div>
    </div>
    <?= str_replace(
        '<form',
        '<form class="contact-form__form" onsubmit="return validateForm()"',
        $arResult["FORM_HEADER"]
    ) ?>

    <?php foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) : ?>
        <?php if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] === 'hidden') : ?>
            <?= $arQuestion["HTML_CODE"] ?>
        <?php elseif ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] !== 'textarea') : ?>
            <?php
            $inputNotification = "";
            $inputId = "";
            $inputType = "text";
            $input = '';
            $validationAttr = '';

            // Для полей ввода: 1 => Имя, 2 => Email, 3 => Компания/Должность, 4 => Номер телефона, 5 => Сообщение
            switch ($arQuestion['STRUCTURE'][0]['ID']) {
                case 1:
                    $inputNotification = "Поле должно содержать не менее 3-х символов";
                    $inputId = "medicine_name";
                    $input = '<input class="input__input" type="text" name="form_text_1"
                        id="' . $inputId . '" value="" required minlength="3" oninput="validateField(this)">';
                    break;
                case 2:
                    $inputNotification = "Неверный формат почты";
                    $inputId = "medicine_email";
                    $inputType = "email";
                    $input = '<input class="input__input" type="email" name="form_text_2"
                        id="' . $inputId . '" value="" required oninput="validateField(this)">';
                    break;
                case 3:
                    $inputNotification = "Поле должно содержать не менее 3-х символов";
                    $inputId = "medicine_company";
                    $input = '<input class="input__input" type="text" name="form_text_3"
                        id="' . $inputId . '" value="" required minlength="3" oninput="validateField(this)">';
                    break;
                case 4:
                    $inputNotification = "Неверный формат телефона";
                    $inputId = "medicine_phone";
                    $inputType = "tel";
                    $input = '<input class="input__input" type="tel" name="form_text_4" id="' . $inputId . '"
                        data-inputmask="\'mask\': \'+79999999999\', \'clearIncomplete\':
                        \'true\'" maxlength="12" x-autocompletetype="phone-full"
                        value="" required pattern="\+7\d{10}" oninput="validateField(this)">';
                    $validationAttr = 'data-phone="true"';
                    break;
            }
            ?>
            <div class="input contact-form__input">
                <label class="input__label" for="<?= $inputId ?>">
                    <div class="input__label-text"><?= $arQuestion["CAPTION"] ?></div>
                    <?= $input ?>
                    <div class="input__notification"
                        id="<?= $inputId ?>_notification"
                        style="display:none;color:red;">
                        <?= $inputNotification ?>
                    </div>
                </label>
            </div>
        <?php else : ?>
            <div class="contact-form__form-message">
                <div class="input"><label class="input__label" for="medicine_message">
                        <div class="input__label-text"><?= $arQuestion["CAPTION"] ?></div>
                        <textarea class="input__input" name="form_textarea_5" type="text" id="medicine_message"
                            value="" required oninput="validateField(this)"></textarea>
                    </label></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="contact-form__bottom">
        <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
            ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
            данных&raquo;.
        </div>
        <input class="form-button contact-form__bottom-button" type="submit" name="web_form_apply" value="Оставить заявку" />
    </div>
</div>

<script>
    function validateField(input) {
        const notification = document.getElementById(input.id + '_notification');

        // Проверка полей: имя, компания, номер телефона, почта
        if (input.checkValidity()) {
            notification.style.display = 'none';
            input.classList.remove('invalid');
        } else {
            notification.style.display = 'block';
            input.classList.add('invalid');
        }
    }

    function validateForm() {
        let isValid = true;
        const inputs = document.querySelectorAll('.input__input, textarea');

        inputs.forEach(input => {
            validateField(input);
            if ((input.tagName === 'TEXTAREA' && input.value.length < 10) ||
                (input.tagName !== 'TEXTAREA' && !input.checkValidity())) {
                isValid = false;
            }
        });

        return isValid;
    }
</script>