<table width="100%">
  <tr>
    <th>是否必填:</th>
    <td><select name="extra[required]" class="easyui-combobox">
        <option value="0" <?php if($_Extra['required']=='0'){?>selected="selected"<?php }?>>否</option>
        <option value="1" <?php if($_Extra['required']=='1'){?>selected="selected"<?php }?>>是</option>
      </select></td>
  </tr>
  <tr>
    <th>是否密码:</th>
    <td><select name="extra[is_password]" class="easyui-combobox">
        <option value="0" <?php if($_Extra['is_password']=='0'){?>selected="selected"<?php }?>>否</option>
        <option value="1" <?php if($_Extra['is_password']=='1'){?>selected="selected"<?php }?>>是</option>
      </select></td>
  </tr>
  <tr>
    <th>表单样式</th>
    <td><textarea name="extra[style]" class="easyui-textbox" data-options="multiline:true" style="width:300px; height:100px;"><?php echo $_Extra['style'];?></textarea></td>
  </tr>
</table>