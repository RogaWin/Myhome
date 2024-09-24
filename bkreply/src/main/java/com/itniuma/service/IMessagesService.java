package com.itniuma.service;


import com.itniuma.pojo.Messages;
import com.itniuma.pojo.Result;

/**
 * <p>
 *  服务类
 * </p>
 *
 * @author 罗佳炜
 * @since 2024-09-24
 */
public interface IMessagesService {



    Result addMessage(Messages messages);

    Result listAll();

    Result deleteMessage(Integer id);

    Result detail(Integer id);

    Result updateMessage(Messages messages);
}
