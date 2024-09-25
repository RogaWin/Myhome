package com.itniuma.pojo;
import java.time.LocalDateTime;
import java.io.Serializable;
import io.swagger.annotations.ApiModel;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.experimental.Accessors;

/**
 * <p>
 * 
 * </p>
 *
 * @author 罗佳炜
 * @since 2024-09-24
 */
@Data
@EqualsAndHashCode(callSuper = false)
@Accessors(chain = true)
@ApiModel(value="Messages对象", description="")
public class Messages implements Serializable {

    private static final long serialVersionUID = 1L;

    private Long id;
    private String img;
    private String content;
    private LocalDateTime createdTime;


}
