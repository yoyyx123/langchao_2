
<form class="form-horizontal" action="<?php echo site_url('ctl=member&act=do_member_edit');?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
 <div class="col-lg-1 col-md-1"></div>    
 <div class="col-lg-10 col-md-10">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="110px">客户编号</td>
                                <td>
                                    <div id="codediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="客户编号" name="code" id="code"value="<?echo $member['code']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>客户全称</td>
                                <td>
                                    <div id="namediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="客户全称" name="name" id="name" value="<?echo $member['name']; ?>">
                                    </div>                                    
                                </td>
                            </tr>
                            <tr>
                                <td width="80px">客户简称</td>
                                <td>
                                    <div id="short_namediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="客户简称" name="short_name" id="short_name" value="<?echo $member['short_name']; ?>">
                                    </div>
                                </td>
                            </tr>                          
                            <tr>
                                <td>客户所属地</td>
                                <td>
                                    <div id="citydiv" class="input-group col-xs-4">
                                    <select name="city" id="city">                                        
                                       <?php foreach ($city_list as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$member['city']) echo "selected=selected";?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>                                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>客户属性</td>
                                <td>
                                    <div id="member_typediv" class="input-group col-xs-4">
                                    <select name="member_type" id="member_type">
                                       <?php foreach ($member_type as $key => $value) {?>
                                        <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$member['member_type']) echo "selected=selected";?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </td>
                            </tr> 
                            <tr>
                                <td>地址</td>
                                <td>
                                    <div id="addrdiv" class="input-group col-xs-4">
                                    <input type="text" placeholder="地址" name="addr" id="addr" value="<?echo $member['addr']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>公交/地铁</td>
                                <td>
                                    <div id="busdiv" class="input-group col-xs-4">
                                    <input type="text" placeholder="公交/地铁" name="bus" id="bus" value="<?echo $member['bus']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>客户联系人</td>
                                <td>
                                    <div id="contactsdiv" class="input-group col-xs-4">
                                    <input type="text" placeholder="客户联系人" name="contacts" id="contacts" value="<?echo $member['contacts']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>联系电话</td>
                                <td>
                                    <div id="mobilediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="联系电话" name="mobile" id="mobile" value="<?echo $member['mobile']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>传真</td>
                                <td>
                                    <div id="faxdiv" class="input-group col-xs-4">
                                    <input type="text" placeholder="传真" name="fax" id="fax" value="<?echo $member['fax']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>工程项目负责人</td>
                                <td>
                                    <div id="project_mandiv" class="input-group col-xs-4">
                                    <input type="text" placeholder="工程项目负责人" name="project_man" id="project_man" value="<?echo $member['project_man']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>联系电话</td>
                                <td>
                                    <div id="project_mobilediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="联系电话" name="project_mobile" id="project_mobile" value="<?echo $member['project_mobile']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>日常业务负责人</td>
                                <td>
                                    <div id="business_mandiv" class="input-group col-xs-4">
                                    <input type="text" placeholder="日常业务负责人" name="business_man" id="business_man" value="<?echo $member['business_man']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>联系电话</td>
                                <td>
                                    <div id="business_mobilediv" class="input-group col-xs-4">
                                    <input type="text" placeholder="联系电话" name="business_mobile" id="business_mobile" value="<?echo $member['business_mobile']; ?>">
                                    </div>
                                </td>
                            </tr>                                                                                                                                                                                                                              
                        </tbody>
                    </table>

                </div>
                <div class="col-lg-7 col-md-4">
                    <input type="hidden" name="id" id="id" value="<?php echo $member['id']?>">                    
                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">修改</button>
                    </p>
                </div> 
</form>