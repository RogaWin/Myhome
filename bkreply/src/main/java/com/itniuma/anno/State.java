package com.itniuma.anno;

import com.itniuma.validation.StateValidation;
import jakarta.validation.Constraint;
import jakarta.validation.Payload;

import java.lang.annotation.*;

import static java.lang.annotation.ElementType.FIELD;
import static java.lang.annotation.RetentionPolicy.RUNTIME;

@Documented
@Target(FIELD)
@Retention(RUNTIME)
@Constraint(
        validatedBy = {StateValidation.class}//验证器
)
public @interface State {
    // 提示
    String message() default "{state参数的值只能是已发布或者草稿}";
    // 分组
    Class<?>[] groups() default {};
    // 负载
    Class<? extends Payload>[] payload() default {};

}
