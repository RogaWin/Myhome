package com.itniuma.controller;


import com.itniuma.pojo.Messages;
import com.itniuma.pojo.Result;
import com.itniuma.service.IMessagesService;
import io.swagger.annotations.ApiOperation;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

/**
 * <p>
 *  前端控制器
 * </p>
 *
 * @author 罗佳炜
 * @since 2024-09-24
 */
@RestController
@RequestMapping("/messages")
public class MessagesController {
    @Autowired
    private IMessagesService messagesService;
    @ApiOperation("添加信息")
    @RequestMapping("/add")
    public Result add(
            @RequestBody Messages messages
            ){
        return messagesService.addMessage(messages);
    }

    @ApiOperation("查询所有信息")
    @RequestMapping("/list")
    public Result list(){
        return messagesService.listAll();
    }

    @ApiOperation("删除信息")
    @DeleteMapping("/delete")
    public Result delete(@RequestParam("id") Integer id){
        return messagesService.deleteMessage(id);
    }

    @ApiOperation("查看详细")
    @RequestMapping("/detail")
    public Result detail(Integer id){
        return messagesService.detail(id);
    }

    @ApiOperation("修改信息")
    @RequestMapping("/update")
    public Result update(Messages messages){
        return messagesService.updateMessage(messages);
    }
}
