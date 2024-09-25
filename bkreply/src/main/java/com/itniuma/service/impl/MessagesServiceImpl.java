package com.itniuma.service.impl;


import com.itniuma.mapper.MessagesMapper;
import com.itniuma.mapper.UserMapper;
import com.itniuma.pojo.Messages;
import com.itniuma.pojo.Result;
import com.itniuma.pojo.User;
import com.itniuma.service.IMessagesService;
import com.itniuma.utils.ThreadLocalUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Map;

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

    @Autowired
    private UserMapper userMapper;

    @Override
    public Result addMessage(Messages messages) {
        if(messages==null||messages.getContent()==null){
            return Result.error("添加失败");
        }
        //获取用户信息
        Map<String,Object> map = ThreadLocalUtil.get();
        Long userId = Long.valueOf((Integer) map.get("id"));
        messages.setId(userId);
        User user = userMapper.findById(Math.toIntExact(userId));
        messages.setImg(user.getUserPic());
        messages.setCreatedTime(LocalDateTime.now());
        boolean added = messagesMapper.addMessage(messages);
        if(!added){
            return Result.error("添加失败");
        }
        return Result.success("添加成功");
    }

    @Override
    public Result listAll() {
        List<Messages> messagesList = messagesMapper.listAll();
        if(messagesList==null){
            return Result.error("获取失败");
        }
        return Result.success(messagesList);
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
