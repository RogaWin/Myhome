package com.itniuma.service.impl;


import com.itniuma.mapper.MessagesMapper;
import com.itniuma.pojo.Messages;
import com.itniuma.pojo.Result;
import com.itniuma.service.IMessagesService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;

/**
 * <p>
 *  服务实现类
 * </p>
 *
 * @author 罗佳炜
 * @since 2024-09-24
 */
@Service
public class MessagesServiceImpl implements IMessagesService {

    @Autowired
    private MessagesMapper messagesMapper;

    @Override
    public Result addMessage(Messages messages) {
        if(messages==null||messages.getContent()==null){
            return Result.error("添加失败");
        }
        messages.setCreatedTime(LocalDateTime.now());
        boolean added = messagesMapper.addMessage(messages);
        if(!added){
            return Result.error("添加失败");
        }
        return Result.success("添加成功");
    }

    @Override
    public Result listAll() {
        boolean isSuccess = messagesMapper.listAll();
        return isSuccess?Result.success():Result.error("获取失败");
    }

    @Override
    public Result deleteMessage(Integer id) {
        boolean isSuccess = messagesMapper.deleteMessage(id);
        return isSuccess?Result.success():Result.error("删除失败");
    }

    @Override
    public Result detail(Integer id) {
        Messages messages = messagesMapper.detail(id);
        if(messages==null){
            return Result.error("获取失败");
        }
        if(messages.getContent()==null){
            return Result.error("获取失败");
        }
        return Result.success(messages);
    }

    @Override
    public Result updateMessage(Messages messages) {
        boolean isSuccess = messagesMapper.updateMessage(messages);
        return isSuccess?Result.success():Result.error("更新失败");
    }
}
