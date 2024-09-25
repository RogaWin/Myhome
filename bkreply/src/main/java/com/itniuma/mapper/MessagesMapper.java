package com.itniuma.mapper;


import com.itniuma.pojo.Messages;
import org.apache.ibatis.annotations.Mapper;

import java.util.List;

/**
 * <p>
 *  Mapper 接口
 * </p>
 *
 * @author 罗佳炜
 * @since 2024-09-24
 */
@Mapper
public interface MessagesMapper {

    boolean addMessage(Messages messages);

     List<Messages> listAll();

    boolean deleteMessage(Integer id);

    Messages detail(Integer id);

    boolean updateMessage(Messages messages);
}
