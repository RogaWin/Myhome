package com.itniuma.mapper;


import com.itniuma.pojo.Messages;

/**
 * <p>
 *  Mapper 接口
 * </p>
 *
 * @author 罗佳炜
 * @since 2024-09-24
 */
public interface MessagesMapper {

    boolean addMessage(Messages messages);

    boolean listAll();

    boolean deleteMessage(Integer id);

    Messages detail(Integer id);

    boolean updateMessage(Messages messages);
}
