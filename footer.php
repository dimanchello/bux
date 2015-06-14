</div></div></div>

            <div id="leftcolumn">

                <?php if(!isGuest()): ?>
                <?php $user = getUserParam($connect); ?>
                <fieldset>
                    <legend>Пользовательское меню:</legend>
                    <table width="100%">
                        <tr>
                            <td>Баланс:</td>
                            <td><?php echo $user['balance']; ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>Рефералов:</td>
                            <td><?php echo $user['referals']; ?>&nbsp;чел.</td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td colspan="2"><a style="font-size: 15px;" href = "<?php echo createUrl('surf'); ?>">Просмотр рекламы</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href = "<?php echo createUrl('payin'); ?>">Пополнить баланс</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href = "<?php echo createUrl('payout'); ?>">Вывести средства</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href = "<?php echo createUrl('banners'); ?>">Рекламные материалы</a></td>
                        </tr>
                    </table>
                    <?php if(getConfig('bonus', $connect) != 0 && hasBonus($connect)): ?>
                    <center><b><span id = "bonus"><img src="images/bonus.png" width="100" height="100" onclick="sendBonus()" style="cursor: pointer;" /></span></b></center>
                    <script type="text/javascript">
                    function sendBonus(){
                        $.post("<?php echo baseUrl(); ?>/ajax/ajax_bonus.php", '', function(data){
                            $("#bonus").fadeOut(500, function(){
                                $(this).html(data).fadeIn(100)
                            });
                        });
                    }
                    </script>
                    <?php endif; ?>
                </fieldset>
                <div id="navmainlistline">&nbsp;</div>
                <?php endif; ?>

                <fieldset>
                    <legend>Статистика проекта:</legend>
                    <table width="100%">
                        <tr>
                            <td>За клик:</td>
                            <td><?php echo getConfig('click', $connect); ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>За реф. клик:</td>
                            <td><?php echo getConfig('refclick', $connect); ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>Минимум к выплате:</td>
                            <td><?php echo getConfig('minimum', $connect); ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>Пользователей:</td>
                            <td><?php echo getConfig('users', $connect); ?>&nbsp;чел.</td>
                        </tr>
                        <tr>
                            <td>Выплачено:</td>
                            <td><?php echo getConfig('payout', $connect); ?>&nbsp;р.</td>
                        </tr>
                        <tr>
                            <td>Хитов:</td>
                            <td><?php echo getConfig('hits', $connect); ?>&nbsp;шт.</td>
                        </tr>

                    </table>

                </fieldset>
                <div id="navmainlistline">&nbsp;</div>
            </div>
            <div id="footer">
                &copy; Copyright 2015 
            </div>
    </body>
</html>